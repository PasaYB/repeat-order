# syntax=docker/dockerfile:1.7

# ---------------------------------------------------------------------------
# Composer binary (only copied into the vendor stage)
# ---------------------------------------------------------------------------
FROM docker.io/library/composer:2.10.3 AS composer

# ---------------------------------------------------------------------------
# PHP dependencies (production only)
#
# Use the same PHP minor as the runtime image so Composer platform checks
# (PHP ^8.3, ext-dom, ext-libxml, etc.) are evaluated against the real target.
# ---------------------------------------------------------------------------
FROM docker.io/library/php:8.4.28-cli-bookworm AS vendor

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# ---------------------------------------------------------------------------
# Frontend build (Vite)
#
# resources/js/app.js imports Ziggy directly from vendor/tightenco/ziggy, so
# the production Composer vendor directory must be present at build time.
# ---------------------------------------------------------------------------
FROM docker.io/library/node:22.22-bookworm-slim AS frontend

ARG VITE_APP_NAME=Laravel
ENV VITE_APP_NAME=${VITE_APP_NAME}

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci

COPY --from=vendor /app/vendor ./vendor

COPY vite.config.js postcss.config.js tailwind.config.js jsconfig.json ./
COPY resources ./resources

RUN npm run build

# ---------------------------------------------------------------------------
# Laravel / PHP-FPM runtime
# ---------------------------------------------------------------------------
FROM docker.io/library/php:8.4.28-fpm-bookworm AS app

# The official PHP image already includes pdo_sqlite, sqlite3, mbstring,
# dom, libxml, fileinfo, openssl, tokenizer, and OPcache.
RUN apt-get update \
    && apt-get install -y --no-install-recommends gosu \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-laravel.ini
COPY docker/php-fpm/zz-laravel.conf /usr/local/etc/php-fpm.d/zz-laravel.conf

WORKDIR /var/www/html

# Production PHP dependencies.
COPY --from=vendor /app/vendor ./vendor

# Application source. Runtime data (.env, SQLite DB, logs, build output,
# local uploads) is excluded through .dockerignore.
COPY . .

# Compiled Vite assets and manifest.
COPY --from=frontend /app/public/build ./public/build

# Keep the repository's tracked storage assets in a read-only seed directory.
# The container entrypoint copies them into the persistent upload volume
# without overwriting files that already exist there.
RUN mkdir -p /opt/laravel \
    && mv storage/app/public /opt/laravel/storage-seed \
    && find /opt/laravel/storage-seed -name '.gitignore' -delete \
    && mkdir -p \
        storage/app/public \
        storage/app/private \
        storage/framework/cache/data \
        storage/framework/cache/locks \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache

# Build the package manifest. Configuration and view caching are done at
# container startup, after runtime environment variables are available.
# Route caching is intentionally not used because routes/web.php contains a
# closure route.
RUN php artisan package:discover --ansi

RUN chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        /opt/laravel/storage-seed \
    && chmod -R ug+rwX storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

RUN php-fpm -t

STOPSIGNAL SIGQUIT

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

# ---------------------------------------------------------------------------
# Nginx runtime
#
# This image contains only the built frontend and the public directory. PHP
# source code is not copied here; all PHP requests are forwarded to "app".
# ---------------------------------------------------------------------------
FROM docker.io/library/nginx:1.30.8-alpine AS web

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

COPY public ./public
COPY --from=frontend /app/public/build ./public/build

EXPOSE 80
