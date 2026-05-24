## 1. Tujuan Proyek

Membangun sebuah sistem informasi _booking_ lapangan olahraga berbasis web yang komprehensif, _real-time_, dan terotomatisasi. Sistem ini tidak hanya memfasilitasi pengguna dalam menemukan dan memesan lapangan secara efisien, tetapi juga menyediakan dasbor manajerial bagi admin dan logika sistem mandiri untuk mencegah bentrok jadwal serta mengelola siklus hidup transaksi secara otomatis.

---
## 2. Tech Stack & Justifikasi

| Layer                   | Teknologi                  | Keterangan                                      |
| ----------------------- | -------------------------- | ----------------------------------------------- |
| **Backend Framework**   | Laravel 13                 | Routing, ORM (Eloquent), Auth, Queue, Scheduler |
| **Frontend Styling**    | Tailwind CSS v4            | Utility-first, responsive by default            |
| **Frontend Interaktif** | Alpine.js                  | Reaktivitas ringan tanpa Vue/React              |
| **Templating**          | Laravel Blade              | Server-side rendering + komponen reusable       |
| **Database**            | MySQL 8+                   | Relational, mendukung transaksional (InnoDB)    |
| **Autentikasi**         | Laravel Breeze             | Scaffolding auth ringan berbasis Blade          |
| **Scheduler/Queue**     | Laravel Scheduler + Queue  | Otomatisasi status booking (`cron`)             |
| **Asset Bundler**       | Vite                       | Default Laravel 11, HMR untuk dev               |
| **HTTP Client**         | Axios / Fetch API          | Request AJAX untuk kalender & slot dinamis      |
| **Storage**             | Laravel Storage (local/S3) | Upload foto lapangan                            |
| **Icons**               | Heroicons / Lucide         | Kompatibel Tailwind, SVG inline                 |

---

## 3. Definisi User Roles & Hak Akses

Sistem ini membagi aktor menjadi empat entitas utama dengan batasan akses yang jelas:

**3.1. Pengunjung Biasa (Guest/Unregistered)**
- Dapat melihat daftar lapangan dan melakukan filter berdasarkan jenis olahraga.
- Dapat melihat ketersediaan slot waktu dan kalender jadwal.
- _Batasan:_ Dilarang melakukan _booking_. Harus diarahkan ke halaman login/registrasi jika menekan tombol _booking_.

**3.2. Pengguna Terdaftar (Registered User)**
- Memiliki akses penuh ke _Dashboard Personal_ (ringkasan aktivitas).
- Dapat memilih slot waktu (termasuk _multi-slot_ berurutan) dan melakukan _checkout booking_.
- Dapat mengelola transaksi (melihat status, membatalkan _booking_ aktif yang belum dibayar).
- Dapat melakukan simulasi pembayaran.

**3.3. Administrator (Admin)**
- Memiliki akses ke _Dashboard_ Manajemen.
- Memegang kendali penuh pada operasi CRUD untuk Data Master: Jenis Olahraga dan Lapangan (termasuk mengatur jam operasional).
- Dapat memantau dan mengelola seluruh siklus transaksi _booking_ dari semua pengguna.

**3.4. Sistem (Automated Entity)**
- Berperan sebagai "penjaga gerbang" tak kasat mata di latar belakang.
- Bertugas mengeksekusi validasi mutlak (mencegah _double-booking_, menolak input waktu di masa lampau, memastikan slot masuk dalam jam operasional)
- Bertanggung jawab atas otomatisasi transisi status (_cron jobs/background tasks_), seperti mengubah status menjadi _completed_ saat waktu main selesai.

---
## 4. Skema Database

Struktur database dirancang untuk menjadi normal, relasional, dan mendukung kebutuhan transaksional sistem.

##### 4.1 Daftar Tabel

-   `users`
-   `sports_categories`
-   `facilities`
-   `public_holidays`
-   `venues`
-   `venue_sport_categories` (Pivot)
-   `venue_facilities` (Pivot)
-   `fields`
-   `field_images`
-   `field_operating_hours`
-   `field_pricing`
-   `bookings`
-   `booking_slots`
-   `payments`
-   `reviews`

##### 4.2 Detail Skema

Berikut adalah detail skema untuk setiap tabel, disajikan dalam format pseudo-SQL untuk kejelasan.

##### `users`
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

##### `sports_categories`
```sql
CREATE TABLE sports_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

##### `facilities`
```sql
CREATE TABLE facilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

##### `public_holidays`
```sql
CREATE TABLE public_holidays (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    holiday_date DATE NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

##### `venues`
```sql
CREATE TABLE venues (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    rules TEXT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    refund_policy TEXT NULL,
    reschedule_policy TEXT NULL,
    logo VARCHAR(255) NULL,
    rating_avg DECIMAL(3, 2) NOT NULL DEFAULT 0.00,
    review_count INT UNSIGNED NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

##### `venue_sport_categories` (Pivot)
```sql
CREATE TABLE venue_sport_categories (
    venue_id BIGINT UNSIGNED NOT NULL,
    sports_category_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (venue_id, sports_category_id),
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (sports_category_id) REFERENCES sports_categories(id) ON DELETE CASCADE
);
```

##### `venue_facilities` (Pivot)
```sql
CREATE TABLE venue_facilities (
    venue_id BIGINT UNSIGNED NOT NULL,
    facility_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (venue_id, facility_id),
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
);
```

##### `fields`
```sql
CREATE TABLE fields (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id BIGINT UNSIGNED NOT NULL,
    sports_category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    type ENUM('indoor', 'outdoor', 'semi-indoor') NOT NULL,
    surface_material VARCHAR(100) NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (sports_category_id) REFERENCES sports_categories(id)
);
```

##### `field_images`
```sql
CREATE TABLE field_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    field_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN NOT NULL DEFAULT false,
    sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
```

##### `field_operating_hours`
```sql
CREATE TABLE field_operating_hours (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    field_id BIGINT UNSIGNED NOT NULL,
    -- 0=Sunday, 1=Monday, ..., 6=Saturday
    day_of_week TINYINT UNSIGNED NOT NULL,
    open_time TIME NULL,
    close_time TIME NULL,
    is_open BOOLEAN NOT NULL DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_field_day (field_id, day_of_week),
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
-- Catatan: Relasi 1 lapangan → 7 baris (satu per hari).
```

##### `field_pricing`
```sql
CREATE TABLE field_pricing (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    field_id BIGINT UNSIGNED NOT NULL,
    day_type ENUM('weekday', 'weekend', 'holiday') NOT NULL,
    price_per_slot DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_field_day_type (field_id, day_type),
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
-- Catatan: Harga per slot dipisahkan untuk mendukung skema harga yang berbeda (misal: hari libur/akhir pekan).
```

##### `bookings`
```sql
CREATE TABLE bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    field_id BIGINT UNSIGNED NOT NULL,
    booking_date DATE NOT NULL,
    total_slots TINYINT UNSIGNED NOT NULL,
    total_price DECIMAL(12, 2) NOT NULL,
    status ENUM('pending', 'paid', 'completed', 'cancelled', 'expired') NOT NULL DEFAULT 'pending',
    notes TEXT NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (field_id) REFERENCES fields(id)
);
```

##### `booking_slots`
```sql
CREATE TABLE booking_slots (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    field_id BIGINT UNSIGNED NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id) REFERENCES fields(id),
    -- INDEX UNIK untuk mencegah double-booking (race condition)
    UNIQUE KEY uq_slot (field_id, booking_date, start_time)
);
```

##### `payments`
```sql
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(12, 2) NOT NULL,
    method VARCHAR(50) NOT NULL,
    status ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    reference_code VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);
```

##### `reviews`
```sql
CREATE TABLE reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    venue_id BIGINT UNSIGNED NOT NULL,
    field_id BIGINT UNSIGNED NULL,
    booking_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL, -- 1 to 5
    comment TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE SET NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    UNIQUE KEY uq_user_booking (user_id, booking_id) -- Memastikan 1 user hanya bisa review 1 booking sekali.
);

---
## 5. Struktur Proyek Laravel

```
project-root/
├── app/
│   ├── Console/
│   │   └── Kernel.php              ← Registrasi cron job
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/               ← LoginController, RegisterController
│   │   │   ├── VenueController.php
│   │   │   ├── BookingController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── DashboardController.php
│   │   │   └── ReviewController.php
│   │   │   └── Admin/
│   │   │       ├── AdminDashboardController.php
│   │   │       ├── AdminVenueController.php
│   │   │       ├── AdminFieldController.php      ← Nested under Venue
│   │   │       ├── AdminFacilityController.php
│   │   │       ├── AdminBookingController.php
│   │   │       ├── AdminSportsCategoryController.php
│   │   │       └── AdminPublicHolidayController.php
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php         ← Middleware proteksi rute admin
│   │   └── Requests/
│   │       ├── StoreBookingRequest.php
│   │       ├── StoreVenueRequest.php
│   │       └── StoreFieldRequest.php   ← Disesuaikan untuk konteks venue
│   ├── Models/
│   │   ├── User.php
│   │   ├── Venue.php
│   │   ├── Field.php
│   │   ├── FieldImage.php
│   │   ├── FieldOperatingHour.php
│   │   ├── FieldPricing.php
│   │   ├── SportsCategory.php
│   │   ├── Facility.php
│   │   ├── PublicHoliday.php
│   │   ├── Review.php
│   │   ├── Booking.php
│   │   ├── BookingSlot.php
│   │   └── Payment.php
│   ├── Services/
│   │   └── BookingService.php      ← Logika bisnis: validasi + buat booking (atomic)
│   └── Jobs/
│       ├── ExpireUnpaidBookings.php
│       └── CompleteFinishedBookings.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminUserSeeder.php
│       ├── VenueSeeder.php
│       ├── FieldSeeder.php
│       ├── SportsCategorySeeder.php
│       └── FacilitySeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php       ← Layout publik (navbar + footer)
│   │   │   └── admin.blade.php     ← Layout dashboard admin (sidebar)
│   │   ├── auth/
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── venue-catalog.blade.php
│   │   │   └── venue-detail.blade.php  ← Menampilkan detail venue & field-nya
│   │   ├── dashboard/
│   │   │   ├── index.blade.php
│   │   │   ├── bookings/
│   │   │   └── transactions/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── venues/
│   │   │   │   └── fields/             ← Manajemen field di dalam venue
│   │   │   ├── facilities/
│   │   │   ├── categories/
│   │   │   └── bookings/
│   │   └── errors/
│   │       ├── 404.blade.php
│   │       └── 403.blade.php
│   └── js/
│       ├── app.js
│       └── calendar.js             ← Logika kalender slot (Alpine + Fetch)
├── routes/
│   ├── web.php
│   └── api.php                     ← Endpoint JSON untuk slot availability
└── config/
    └── booking.php                 ← Konfigurasi: durasi slot, batas expiry, dll
```

---
## 6. Struktur Website (Sitemap Lengkap)

#### Area Publik

| Path             | Halaman          | Komponen Utama                               |
| ---------------- | ---------------- | -------------------------------------------- |
| `/`              | Beranda          | Hero, Keunggulan (3 kolom), Lapangan Populer |
| `/catalog`       | Katalog Lapangan | Filter sidebar, Card grid, Pagination        |
| `/fields/{slug}` | Detail Lapangan  | Foto, Info, Kalender Slot Interaktif         |
| `/login`         | Login            | Form auth                                    |
| `/register`      | Registrasi       | Form registrasi                              |
#### Area User

|Path|Halaman|
|---|---|
|`/dashboard`|Dashboard (summary, notifikasi)|
|`/dashboard/booking/confirm`|Konfirmasi Booking|
|`/dashboard/bookings`|Riwayat Booking (filter status)|
|`/dashboard/bookings/{id}`|Detail Transaksi + Invoice|
|`/dashboard/payments/{id}`|Simulasi Pembayaran|

#### Area Admin

|Path|Halaman|
|---|---|
|`/admin`|Dashboard Admin (metrik)|
|`/admin/fields`|List Lapangan|
|`/admin/fields/create`|Tambah Lapangan|
|`/admin/fields/{id}/edit`|Edit Lapangan|
|`/admin/categories`|Manajemen Kategori Olahraga|
|`/admin/bookings`|Pemantauan Booking Global|

#### Halaman Utilitas

| Path            | Halaman                          |
| --------------- | -------------------------------- |
| `*` (404)       | Not Found — "Bola Keluar Garis!" |
| Akses terlarang | Forbidden 403 — "Area Terbatas"  |[Ticket Jira.md](Ticket%20Jira.md)

---
## 7. Alur Konversi (User Journey)
### 7.1 Guest → Registered User

```
Landing Page
  → [CTA: "Mulai Booking"] → Katalog
  → Klik lapangan → Detail Lapangan
  → Klik slot → REDIRECT ke /login
  → Login / Register → Kembali ke Detail Lapangan (redirect_back)
```

### 7.2 User → Paid Booking

```
Detail Lapangan
  → Pilih slot (Alpine.js toggle, slot berubah warna)
  → Sticky button: "Lanjut Konfirmasi (N Slot)" muncul
  → /dashboard/booking/confirm (ringkasan + total harga)
  → Klik "Proses ke Pembayaran"
  → /dashboard/payments/{booking} (simulasi gateway)
  → Klik "Bayar Sekarang" → status: paid → redirect ke invoice
```

### 7.3 Manajemen Pasca-Transaksi

```
/dashboard/bookings
  → Filter: Aktif / Selesai / Dibatalkan / Kedaluwarsa
  → Per baris: [Lihat Invoice] [Bayar Tagihan] [Batalkan]
  → Batalkan: konfirmasi modal Alpine.js → PATCH /bookings/{id}/cancel
```

### 7.4 Admin Operations

```
/admin/fields
  → [+ Tambah Lapangan Baru]
  → Isi form (nama, kategori, harga/slot, foto, jam operasional per hari)
  → [Simpan Data] → redirect ke list dengan flash success
```
---
## 8. Potensi Pengembangan & Peningkatan Kualitas

Bagian ini mendeskripsikan fitur-fitur dan peningkatan yang berada di luar ruang lingkup inti (MVP), namun dapat diimplementasikan untuk meningkatkan nilai, kualitas, dan profesionalisme proyek.

### 8.1. Jaminan Kualitas Melalui Pengujian (Testing)
- **Tujuan**: Memastikan keandalan dan stabilitas kode, terutama pada logika bisnis yang krusial.
- **Implementasi**:
    - **Feature Test**: Membuat skenario pengujian untuk alur utama, seperti registrasi pengguna, proses booking, dan proteksi rute admin.
    - **Unit Test**: Membuat pengujian terisolasi untuk `BookingService`.
    - **Skenario Kritis**: Membuat test case spesifik untuk memvalidasi `lockForUpdate` dengan mencoba membuat dua booking pada slot yang sama secara bersamaan (simulasi _race condition_) dan memastikan sistem hanya mengizinkan satu.

### 8.2. Dasbor Admin Analitis
- **Tujuan**: Memberikan wawasan bisnis kepada admin, tidak hanya data operasional.
- **Implementasi**:
    - **Visualisasi Data**: Membuat halaman "Laporan" baru di panel admin.
    - **Grafik & Metrik**: Menggunakan `Chart.js` (via CDN atau NPM) untuk menampilkan:
        - Grafik pendapatan per bulan.
        - Grafik popularitas lapangan (lapangan mana yang paling sering di-booking).
        - Metrik kunci seperti jumlah booking baru, pembatalan, dan pengguna terdaftar dalam 30 hari terakhir.

### 8.3. Sistem Notifikasi Proaktif
- **Tujuan**: Meningkatkan pengalaman pengguna dengan memberikan informasi relevan secara otomatis.
- **Implementasi**:
    - **Notifikasi Email**: Menggunakan sistem `Mailable` bawaan Laravel.
    - **Trigger Otomatis**:
        - **Setelah Booking**: Kirim email konfirmasi pesanan beserta instruksi pembayaran.
        - **Setelah Pembayaran**: Kirim email invoice/bukti pembayaran.
        - **Pengingat**: Kirim email pengingat 1 jam sebelum booking kedaluwarsa.

### 8.4. Fitur Interaksi Pengguna (Review & Rating)
- **Tujuan**: Membangun aspek komunitas dan memberikan data kualitatif tambahan tentang kualitas lapangan.
- **Implementasi**:
    - **Modifikasi Skema**: Menambah tabel `reviews` (`id`, `user_id`, `field_id`, `booking_id`, `rating`, `comment`, `timestamps`).
    - **Alur Pengguna**: Setelah status booking berubah menjadi `completed`, pengguna mendapatkan opsi untuk memberikan rating (1-5 bintang) dan ulasan pada halaman riwayat bookingnya.
    - **Agregasi Data**: Menampilkan rata-rata rating pada halaman katalog dan detail lapangan.
