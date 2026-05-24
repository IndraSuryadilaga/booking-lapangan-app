# Sistem Booking Lapangan Olahraga

## Deskripsi Proyek
Sistem informasi booking lapangan olahraga berbasis web yang komprehensif, real-time, dan terotomatisasi. Proyek ini bertujuan untuk memfasilitasi pengguna dalam menemukan dan memesan lapangan secara efisien, menyediakan dasbor manajerial bagi admin, serta mengelola siklus hidup transaksi secara otomatis dengan logika sistem mandiri untuk mencegah bentrok jadwal.

## Fitur Utama

### Untuk Pengunjung & Pengguna Terdaftar
-   **Pencarian Lapangan**: Melihat daftar lapangan dan memfilter berdasarkan jenis olahraga.
-   **Ketersediaan Real-time**: Melihat ketersediaan slot waktu dan kalender jadwal lapangan.
-   **Proses Booking**: Memilih slot waktu (mendukung multi-slot berurutan) dan melakukan checkout booking.
-   **Manajemen Transaksi**: Melihat riwayat booking, status transaksi, dan membatalkan booking aktif yang belum dibayar.
-   **Simulasi Pembayaran**: Melakukan simulasi proses pembayaran.

### Untuk Administrator
-   **Dasbor Manajemen**: Akses penuh ke dasbor admin.
-   **Manajemen Data Master**: Operasi CRUD (Create, Read, Update, Delete) untuk jenis olahraga dan data lapangan (termasuk pengaturan jam operasional).
-   **Pemantauan Booking**: Memantau dan mengelola seluruh siklus transaksi booking dari semua pengguna.

### Fitur Otomatisasi Sistem
-   **Pencegahan Double-Booking**: Validasi mutlak di level database dan aplikasi untuk mencegah pemesanan ganda.
-   **Manajemen Slot Otomatis**: Mengubah status booking menjadi 'expired' jika tidak dibayar dalam batas waktu tertentu, dan 'completed' setelah waktu pemakaian lapangan berakhir.

## Teknologi (Tech Stack)

Proyek ini dibangun menggunakan teknologi modern untuk memastikan performa, skalabilitas, dan kemudahan pengembangan:

-   **Backend Framework**: Laravel 13
-   **Frontend Styling**: Tailwind CSS v4
-   **Frontend Interaktif**: Alpine.js
-   **Templating**: Laravel Blade
-   **Database**: MySQL 8+
-   **Autentikasi**: Laravel Breeze
-   **Scheduler/Queue**: Laravel Scheduler + Queue
-   **Asset Bundler**: Vite
-   **HTTP Client**: Axios / Fetch API
-   **Storage**: Laravel Storage (local/S3)
-   **Icons**: Heroicons / Lucide

## Instalasi & Setup Lokal

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repositori**:
    ```bash
    git clone https://github.com/your-username/booking-lapangan.git
    cd booking-lapangan
    ```

2.  **Instal Dependensi PHP**:
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Edit file `.env` dan sesuaikan konfigurasi database Anda (misalnya `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4.  **Setup Database**:
    Pastikan server MySQL Anda berjalan.
    ```bash
    php artisan migrate --seed
    ```
    Ini akan membuat tabel database dan mengisi data awal (termasuk akun admin dan user).

5.  **Instal Dependensi Frontend**:
    ```bash
    npm install
    ```

6.  **Compile Assets**:
    Untuk pengembangan (dengan Hot Module Replacement):
    ```bash
    npm run dev
    ```
    Untuk produksi:
    ```bash
    npm run build
    ```

7.  **Jalankan Server Lokal**:
    ```bash
    php artisan serve
    ```
    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

8.  **Link Storage (untuk upload gambar)**:
    ```bash
    php artisan storage:link
    ```

## User Roles & Hak Akses

Sistem ini membagi aktor menjadi tiga entitas utama dengan batasan akses yang jelas:

-   **Pengunjung Biasa (Guest/Unregistered)**:
    -   Dapat melihat daftar lapangan dan melakukan filter.
    -   Dapat melihat ketersediaan slot waktu.
    -   *Batasan*: Tidak dapat melakukan booking (akan diarahkan ke halaman login/registrasi).

-   **Pengguna Terdaftar (Registered User)**:
    -   Akses penuh ke Dashboard Personal (ringkasan aktivitas).
    -   Dapat memilih slot waktu dan melakukan checkout booking.
    -   Dapat mengelola transaksi dan melakukan simulasi pembayaran.

-   **Administrator (Admin)**:
    -   Akses penuh ke Dashboard Manajemen.
    -   Mengendalikan operasi CRUD untuk Data Master (Jenis Olahraga, Lapangan, Jam Operasional).
    -   Memantau dan mengelola seluruh siklus transaksi booking.

## Potensi Pengembangan (Future Enhancements)

Beberapa fitur dan peningkatan yang dapat diimplementasikan di masa mendatang untuk meningkatkan nilai dan kualitas proyek:

-   **Jaminan Kualitas Melalui Pengujian (Testing)**: Implementasi Unit Test dan Feature Test menggunakan PHPUnit/Pest, khususnya untuk logika booking yang krusial.
-   **Dasbor Admin Analitis**: Penambahan halaman laporan dengan visualisasi data (grafik pendapatan, popularitas lapangan) menggunakan Chart.js.
-   **Sistem Notifikasi Proaktif**: Implementasi notifikasi email untuk konfirmasi booking, pembayaran, dan pengingat kedaluwarsa.
-   **Fitur Interaksi Pengguna (Review & Rating)**: Memungkinkan pengguna memberikan rating dan ulasan untuk lapangan setelah booking selesai.
