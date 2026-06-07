# Aplikasi Booking Lapangan

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-8+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6-646CFF?style=for-the-badge&logo=vite&logoColor=white)

> **Tugas Akhir Mata Kuliah Pemrograman Web**  
> Sistem informasi berbasis web untuk penyewaan lapangan olahraga secara daring.

---

## Deskripsi Singkat

**Aplikasi Booking Lapangan** adalah sistem informasi berbasis web yang dirancang untuk mempermudah proses penyewaan lapangan olahraga. Aplikasi ini memungkinkan pengguna untuk menelusuri lapangan berdasarkan jenis olahraga, memeriksa ketersediaan jadwal secara real-time, melakukan pemesanan slot waktu, hingga menyelesaikan pembayaran dalam satu alur yang terintegrasi.

Proyek ini hadir sebagai solusi atas permasalahan konvensional dalam penyewaan lapangan—seperti bentrok jadwal, proses booking manual, dan kurangnya transparansi ketersediaan. Dengan validasi di level aplikasi dan database, sistem mencegah double-booking, mengelola status transaksi secara otomatis, serta menyediakan dasbor manajerial bagi administrator untuk mengelola data master lapangan, venue, dan seluruh siklus transaksi.

---

## Fitur Utama

### Untuk Pengunjung & Pengguna Terdaftar

- **Autentikasi & Registrasi** — Login, registrasi, dan manajemen profil pengguna (Laravel Breeze).
- **Pencarian & Filter Lapangan** — Menelusuri daftar lapangan dan venue berdasarkan jenis olahraga.
- **Cek Ketersediaan Jadwal** — Kalender interaktif untuk melihat slot waktu yang tersedia secara real-time.
- **Sistem Booking** — Pemesanan slot waktu (mendukung multi-slot berurutan) dengan proses checkout.
- **Manajemen Transaksi** — Riwayat booking, detail transaksi, dan pembatalan booking yang belum dibayar.
- **Simulasi Pembayaran** — Proses pembayaran terintegrasi dalam alur booking.
- **Ulasan & Rating** — Memberikan review setelah booking selesai.

### Untuk Administrator

- **Dasbor Manajemen** — Ringkasan aktivitas dan pemantauan transaksi.
- **Manajemen Venue & Lapangan** — Operasi CRUD untuk venue, lapangan, foto, jam operasional, dan harga.
- **Manajemen Data Master** — CRUD jenis olahraga, fasilitas, dan hari libur nasional.
- **Pemantauan Booking** — Mengelola seluruh siklus transaksi booking dari semua pengguna.

### Otomatisasi Sistem

- **Pencegahan Double-Booking** — Validasi di level database dan aplikasi.
- **Kedaluwarsa Otomatis** — Booking yang tidak dibayar dalam batas waktu ditandai sebagai *expired*.
- **Penyelesaian Otomatis** — Status booking berubah menjadi *completed* setelah waktu pemakaian berakhir.

---

## Prasyarat (Prerequisites)

Pastikan perangkat lunak berikut sudah terinstal sebelum menjalankan proyek:

| Perangkat Lunak | Versi Minimum |
|---|---|
| [PHP](https://www.php.net/downloads) | 8.3 atau lebih baru |
| [Composer](https://getcomposer.org/download/) | 2.x |
| [Node.js](https://nodejs.org/) | 18.x atau lebih baru |
| [NPM](https://www.npmjs.com/) | 9.x atau lebih baru (terinstal bersama Node.js) |
| [MySQL](https://dev.mysql.com/downloads/) | 8.0 atau lebih baru |
| [Git](https://git-scm.com/downloads) | Versi terbaru |

**Ekstensi PHP yang diperlukan:** `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`

---

## Langkah Instalasi (Getting Started)

### 1. Clone Repositori

```bash
git clone https://github.com/IndraSuryadilaga/booking-lapangan-app.git
cd booking-lapangan-app
```

### 2. Instal Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_lapangan
DB_USERNAME=root
DB_PASSWORD=
```

Buat database kosong di MySQL sebelum menjalankan migrasi:

```sql
CREATE DATABASE booking_lapangan;
```

### 4. Migrasi & Seeder Database

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel dan mengisi data awal (akun admin, kategori olahraga, venue, lapangan, dan data contoh lainnya).

### 5. Tautkan Storage (untuk Upload Gambar)

```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi

Buka **dua terminal terpisah** dan jalankan perintah berikut:

**Terminal 1 — Asset bundler (Vite):**

```bash
npm run dev
```

**Terminal 2 — Server Laravel:**

```bash
php artisan serve
```

Aplikasi dapat diakses di [http://127.0.0.1:8000](http://127.0.0.1:8000).

> **Alternatif:** Jalankan semua layanan sekaligus dengan `composer dev` (server, queue, log, dan Vite berjalan bersamaan).

### 7. Jalankan Scheduler (Opsional, untuk Otomatisasi)

Sistem menggunakan job terjadwal untuk mengelola status booking. Jalankan di terminal terpisah:

```bash
php artisan schedule:work
```

---

## Akun Default (Setelah Seeding)

| Peran | Email | Password |
|---|---|---|
| Super Admin | `superadmin@booking.com` | `password` |
| Pengguna Biasa | `user@booking.com` | `password` |

---

## Struktur Folder

Berikut ringkasan lokasi logika utama dalam proyek:

```
booking-lapangan/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Logika request & response
│   │   │   ├── Admin/          # Controller khusus area admin
│   │   │   └── Auth/           # Controller autentikasi (Breeze)
│   │   └── Middleware/         # Middleware (role, akses admin, dll.)
│   ├── Models/                 # Model Eloquent (Booking, Field, Venue, dll.)
│   └── Jobs/                   # Job terjadwal (expire & complete booking)
├── database/
│   ├── migrations/             # Skema tabel database
│   └── seeders/                # Data awal untuk pengujian
├── resources/
│   ├── views/                  # Template Blade (halaman & komponen UI)
│   ├── css/                    # Stylesheet Tailwind CSS
│   └── js/                     # JavaScript & Alpine.js
├── routes/
│   ├── web.php                 # Rute aplikasi web
│   └── auth.php                # Rute autentikasi
└── public/                     # Entry point & aset publik
```

---

## Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| Backend Framework | Laravel 13 |
| Bahasa Pemrograman | PHP 8.3+ |
| Frontend Styling | Tailwind CSS |
| Frontend Interaktif | Alpine.js |
| Templating | Laravel Blade |
| Database | MySQL 8+ |
| Autentikasi | Laravel Breeze |
| Asset Bundler | Vite 6 |
| HTTP Client | Axios |
| Scheduler & Queue | Laravel Scheduler + Database Queue |

---

## Tim Pengembang

| No | Nama                      | NIM             |
|:---:|---------------------------|-----------------|
| 1 | Indra Suryadilaga         | (2410817310014) |
| 2 | Muhammad Dzul Fathi Ahyan | (2410817210011) |
| 3 | Orlando Sugian            | (2410817210017) |

> **Dosen Pengampu:** Ir. Muhammad Alkaff, S.Kom., M.Kom., Ph.D.

> **Mata Kuliah:** Pemrograman Web II.

> **Institusi:** Universitas Lambung Mangkurat.

> **Tahun Akademik:** 2026.

---

## Lisensi

Proyek ini dikembangkan sebagai tugas akhir mata kuliah Pemrograman Web dan bersifat edukatif. Penggunaan di luar konteks akademik dapat disesuaikan dengan kebijakan institusi dan tim pengembang.
