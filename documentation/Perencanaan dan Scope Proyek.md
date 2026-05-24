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

##### 4.1 Daftar Tabel

```
users
sports_categories
fields
field_operating_hours
bookings
booking_slots
payments
```

##### 4.2 Detail Skema

##### `users`
```sql
id, name, email, password, role ENUM('user','admin'),
email_verified_at, remember_token, timestamps
```

##### `sports_categories`
```sql
id, name, slug, icon (nullable), is_active BOOLEAN, timestamps
```

##### `fields`
```sql
id, sports_category_id (FK), name, slug, description,
price_per_slot (DECIMAL 10,2), photo (nullable),
is_active BOOLEAN, timestamps
```

##### `field_operating_hours`
```sql
id, field_id (FK), day_of_week TINYINT (0=Minggu..6=Sabtu),
open_time TIME, close_time TIME, is_open BOOLEAN, timestamps
```

> Relasi: 1 lapangan → 7 baris (satu per hari).

##### `bookings`
```sql
id, user_id (FK), field_id (FK),
booking_date DATE, total_slots TINYINT,
total_price DECIMAL(10,2),
status ENUM('pending','paid','completed','cancelled','expired'),
notes (nullable), timestamps
```

##### `booking_slots`
```sql
id, booking_id (FK), field_id (FK),
booking_date DATE, start_time TIME, end_time TIME, timestamps

-- INDEX UNIK untuk mencegah double-booking:
UNIQUE KEY uq_slot (field_id, booking_date, start_time)
```

##### `payments`
```sql
id, booking_id (FK), amount DECIMAL(10,2),
method VARCHAR(50), status ENUM('pending','success','failed'),
paid_at (nullable TIMESTAMP), reference_code, timestamps
```

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
│   │   │   ├── BookingController.php
│   │   │   ├── FieldController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── DashboardController.php
│   │   │   └── Admin/
│   │   │       ├── AdminDashboardController.php
│   │   │       ├── AdminFieldController.php
│   │   │       ├── AdminBookingController.php
│   │   │       └── AdminSportsCategoryController.php
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php         ← Middleware proteksi rute admin
│   │   └── Requests/
│   │       ├── StoreBookingRequest.php
│   │       └── StoreFieldRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Field.php
│   │   ├── SportsCategory.php
│   │   ├── FieldOperatingHour.php
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
│       ├── SportsCategorySeeder.php
│       └── FieldSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php       ← Layout publik (navbar + footer)
│   │   │   └── admin.blade.php     ← Layout dashboard admin (sidebar)
│   │   ├── auth/
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── catalog.blade.php
│   │   │   └── field-detail.blade.php
│   │   ├── dashboard/
│   │   │   ├── index.blade.php
│   │   │   ├── bookings/
│   │   │   └── transactions/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── fields/
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
| Akses terlarang | Forbidden 403 — "Area Terbatas"  |

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
