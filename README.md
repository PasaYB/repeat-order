## Cara Clone dan Menjalankan Proyek

### 1. Clone repository

Ganti URL berikut dengan URL repository proyek yang sebenarnya.

```bash
git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
```

Masuk ke direktori proyek:

```bash
cd NAMA-REPOSITORY
```

### 2. Instal dependensi

Instal dependensi PHP:

```bash
composer install
```

Instal dependensi frontend:

```bash
npm install
```

### 3. Konfigurasi environment

Salin file konfigurasi environment:

```bash
cp .env.example .env
```

Buat application key Laravel:

```bash
php artisan key:generate
```

### 4. Konfigurasi database

Biarkan default menggunakan sqlite

### 5. Jalankan migration dan seeder

Jalankan perintah berikut untuk membuat tabel dan mengisi data awal jika seeder sudah tersedia:

```bash
php artisan migrate --seed
```

**Perhatian:** jangan gunakan `migrate:fresh` pada database yang berisi data penting karena perintah tersebut akan menghapus tabel sebelum membuatnya kembali.

### 6. Jalankan aplikasi

Buka terminal pertama untuk menjalankan server Laravel:

```bash
php artisan serve
```

Buka terminal kedua untuk menjalankan frontend:

```bash
npm run dev
```

Akses aplikasi melalui alamat:

```text
http://127.0.0.1:8000
```

Biarkan kedua proses tetap berjalan selama pengembangan.

## Catatan

- Pastikan layanan database aktif sebelum menjalankan migration.
- Pastikan file `.env` sudah dikonfigurasi dengan benar.
- Data restoran dan menu bergantung pada seeder yang tersedia di repository.
- Jangan mengunggah file `.env` atau kredensial database ke repository publik.