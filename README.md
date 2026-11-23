# SuJa

## Contributors

| No. | Nama | NIM |
|---|---|---|
| 1 | Lanang Gading Pasa | 123250174 |
| 2 | Indra Ramadhan | 123250129 |
| 3 | Danang Nur Himawan | 123250222 |

---

## Deskripsi

**SuJa** adalah aplikasi pemesanan makanan berbasis web yang memungkinkan pengguna untuk menjelajahi restoran, melihat menu makanan, menambahkan makanan ke keranjang, dan melakukan pemesanan secara online.

Project ini dikembangkan sebagai bagian dari tugas perkuliahan dengan menggunakan Laravel sebagai backend serta Vue.js dan Inertia.js sebagai frontend.

## Fitur

- Melihat daftar restoran dan kategori makanan.
- Melihat detail restoran beserta menu yang tersedia.
- Menambahkan dan mengelola menu di keranjang.
- Melakukan checkout dan membuat pesanan.
- Melihat riwayat serta detail pesanan.
- Melihat lokasi restoran melalui peta.
- Simulasi perubahan status pesanan.

## Teknologi

- **Backend:** Laravel
- **Frontend:** Vue.js
- **Bridge:** Inertia.js
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Map:** Leaflet dan OpenStreetMap

## Persyaratan

Pastikan perangkat telah memiliki:

- PHP sesuai persyaratan versi Laravel yang digunakan.
- Composer
- Node.js dan NPM
- MySQL
- Git

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
```

Masuk ke direktori project:

```bash
cd NAMA-REPOSITORY
```

### 2. Install Dependencies

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database baru di MySQL, kemudian sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=sqlite
```

Sesuaikan nilai konfigurasi dengan database lokal yang digunakan.

### 5. Migrasi dan Seeder

Jalankan migrasi database beserta seeder:

```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Jalankan development server frontend pada terminal terpisah:

```bash
npm run dev
```

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

## Catatan

Pastikan server MySQL aktif sebelum menjalankan migrasi dan aplikasi. Untuk fitur simulasi perubahan status pesanan, jalankan Laravel Scheduler menggunakan perintah berikut pada terminal terpisah:

```bash
php artisan schedule:work
```

---

**SuJa** — Web-based Food Ordering Application.
