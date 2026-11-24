#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is not set. Provide it as an environment variable." >&2
    exit 1
fi

DB_PATH="${DB_DATABASE:-/var/lib/laravel/database.sqlite}"
DB_DIR="$(dirname "$DB_PATH")"

export DB_CONNECTION="${DB_CONNECTION:-sqlite}"
export DB_DATABASE="$DB_PATH"

mkdir -p "$DB_DIR"
if [ ! -f "$DB_PATH" ]; then
    touch "$DB_PATH"
fi

mkdir -p \
    /var/www/html/storage/app/public \
    /var/www/html/storage/app/private \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/cache/locks \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

# Copy the repository's tracked public storage assets (for example restaurant
# images) into the persistent upload volume on first boot. Existing files are
# never overwritten.
if [ -d /opt/laravel/storage-seed ]; then
    cp -a -n /opt/laravel/storage-seed/. /var/www/html/storage/app/public/ || true
fi

# Make the persistent volumes readable/writable by PHP-FPM workers.
chown -R www-data:www-data \
    "$DB_DIR" \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

chmod 775 "$DB_DIR"
chmod 664 "$DB_PATH"
chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache

# public/storage -> storage/app/public (created at runtime, never baked in).
if [ ! -e /var/www/html/public/storage ] && [ ! -L /var/www/html/public/storage ]; then
    ln -s ../storage/app/public /var/www/html/public/storage
fi

# Cache configuration from the runtime environment. This must not be done in
# the Dockerfile, otherwise build-time/default values would be baked in.
gosu www-data php artisan config:cache

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."
    gosu www-data php artisan migrate --force --no-interaction
fi

gosu www-data php artisan view:cache

echo "Starting PHP-FPM..."
exec "$@"
