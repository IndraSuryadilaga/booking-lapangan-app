# Perencanaan dan Scope Proyek
## Sistem Booking Lapangan — v3.0

---

## 1. Tujuan Proyek

Membangun sistem booking lapangan olahraga berbasis web yang otomatis dan real-time. Sistem menggunakan arsitektur **Venue → Fields**, di mana satu Venue (GOR/Sport Center) dikelola oleh satu Admin dan dapat memiliki banyak Field (lapangan).

---

## 2. Tech Stack

| Layer | Teknologi |
| --- | --- |
| **Backend** | Laravel 13 |
| **Frontend** | Tailwind CSS v4 + Alpine.js |
| **Database** | MySQL 8 |
| **Auth** | Laravel Breeze |
| **Task** | Scheduler & Queue |

---

## 3. User Roles

| Kemampuan | `super-admin` | `admin` | `user` | Guest |
|---|:---:|:---:|:---:|:---:|
| Buat & kelola semua Venue | ✅ | ❌ | ❌ | ❌ |
| Assign Admin ke Venue | ✅ | ❌ | ❌ | ❌ |
| Kelola Venue milik sendiri | ✅ | ✅ | ❌ | ❌ |
| CRUD Field di Venue sendiri | ✅ | ✅ | ❌ | ❌ |
| Kelola Field di Venue lain | ✅ | ❌ | ❌ | ❌ |
| Kelola Kategori Olahraga | ✅ | ❌ | ❌ | ❌ |
| Kelola Fasilitas | ✅ | ❌ | ❌ | ❌ |
| Kelola Hari Libur Nasional | ✅ | ❌ | ❌ | ❌ |
| Pantau semua transaksi | ✅ | ❌ | ❌ | ❌ |
| Pantau transaksi di Venue sendiri | ✅ | ✅ | ❌ | ❌ |
| Booking lapangan | ❌ | ❌ | ✅ | ❌ |
| Riwayat & pembatalan booking | ❌ | ❌ | ✅ | ❌ |
| Beri ulasan & rating | ❌ | ❌ | ✅ | ❌ |
| Lihat katalog & detail lapangan | ✅ | ✅ | ✅ | ✅ |

---

## 4. Skema Database

Struktur database dirancang ternormalisasi (1NF–3NF), relasional, dan mendukung kebutuhan transaksional sistem.

### 4.1 Daftar Tabel
- `sports_categories`
- `facilities`
- `public_holidays`
- `users`
- `venues`
- `venue_sport_categories` (Pivot)
- `venue_facilities` (Pivot)
- `fields`
- `field_images`
- `field_operating_hours`
- `field_pricing`
- `bookings`
- `booking_slots`
- `payments`
- `reviews`

### 4.2 Detail Skema

##### `users`
```sql
CREATE TABLE users (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(150)    NOT NULL,
    email             VARCHAR(191)    NOT NULL UNIQUE,
    password          VARCHAR(255)    NOT NULL,
    role              ENUM('user', 'admin', 'super-admin') NOT NULL DEFAULT 'user',
    phone             VARCHAR(20)     NULL,
    avatar            VARCHAR(255)    NULL,
    email_verified_at TIMESTAMP       NULL,
    remember_token    VARCHAR(100)    NULL,
    created_at        TIMESTAMP       NULL,
    updated_at        TIMESTAMP       NULL
);
```

##### `sports_categories`
```sql
CREATE TABLE sports_categories (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)   NOT NULL,
    slug       VARCHAR(110)   NOT NULL UNIQUE,
    icon       VARCHAR(255)   NULL,
    is_active  BOOLEAN        NOT NULL DEFAULT true,
    created_at TIMESTAMP      NULL,
    updated_at TIMESTAMP      NULL
);
```

##### `facilities`
```sql
CREATE TABLE facilities (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)   NOT NULL UNIQUE,
    icon       VARCHAR(255)   NULL,
    created_at TIMESTAMP      NULL,
    updated_at TIMESTAMP      NULL
);
```

##### `public_holidays`
```sql
CREATE TABLE public_holidays (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    holiday_date DATE           NOT NULL UNIQUE,
    name         VARCHAR(150)   NOT NULL,
    created_at   TIMESTAMP      NULL,
    updated_at   TIMESTAMP      NULL
);
```

##### `venues`
```sql
-- admin_id: relasi one-to-one dengan users (role='admin').
-- UNIQUE KEY pada admin_id memastikan 1 admin hanya bisa
-- memiliki 1 venue, dan 1 venue hanya dimiliki 1 admin.
-- NULL diizinkan selama venue belum di-assign ke admin.
-- ON DELETE SET NULL: jika akun admin dihapus, venue tidak
-- ikut terhapus — cukup menjadi unassigned.
CREATE TABLE venues (
    id                BIGINT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    admin_id          BIGINT UNSIGNED  NULL,
    name              VARCHAR(191)     NOT NULL,
    slug              VARCHAR(210)     NOT NULL UNIQUE,
    description       TEXT             NULL,
    rules             TEXT             NULL,
    address           VARCHAR(255)     NOT NULL,
    city              VARCHAR(100)     NOT NULL,
    province          VARCHAR(100)     NOT NULL,
    postal_code       VARCHAR(10)      NULL,
    latitude          DECIMAL(10, 8)   NULL,
    longitude         DECIMAL(11, 8)   NULL,
    refund_policy     TEXT             NULL,
    reschedule_policy TEXT             NULL,
    logo              VARCHAR(255)     NULL,
    -- Cache agregasi — diperbarui otomatis oleh Observer/Trigger
    -- setiap kali review baru masuk, menghindari AVG() mahal
    -- saat load halaman katalog.
    rating_avg        DECIMAL(3, 2)    NOT NULL DEFAULT 0.00,
    review_count      INT UNSIGNED     NOT NULL DEFAULT 0,
    is_active         BOOLEAN          NOT NULL DEFAULT true,
    created_at        TIMESTAMP        NULL,
    updated_at        TIMESTAMP        NULL,
    UNIQUE KEY uq_venue_admin (admin_id),
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE SET NULL
);
```

##### `venue_sport_categories` (Pivot)
```sql
-- Satu venue bisa menawarkan banyak jenis olahraga (many-to-many).
CREATE TABLE venue_sport_categories (
    venue_id           BIGINT UNSIGNED NOT NULL,
    sports_category_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (venue_id, sports_category_id),
    FOREIGN KEY (venue_id)           REFERENCES venues(id)           ON DELETE CASCADE,
    FOREIGN KEY (sports_category_id) REFERENCES sports_categories(id) ON DELETE CASCADE
);
```

##### `venue_facilities` (Pivot)
```sql
-- Fasilitas dipisah ke tabel master + pivot untuk mencegah
-- redundansi string dan memudahkan filter pencarian.
CREATE TABLE venue_facilities (
    venue_id    BIGINT UNSIGNED NOT NULL,
    facility_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (venue_id, facility_id),
    FOREIGN KEY (venue_id)    REFERENCES venues(id)     ON DELETE CASCADE,
    FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
);
```

##### `fields`
```sql
CREATE TABLE fields (
    id                 BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id           BIGINT UNSIGNED NOT NULL,
    sports_category_id BIGINT UNSIGNED NOT NULL,
    name               VARCHAR(150)    NOT NULL,
    slug               VARCHAR(180)    NOT NULL UNIQUE,
    description        TEXT            NULL,
    type               ENUM('indoor', 'outdoor', 'semi-indoor') NOT NULL DEFAULT 'indoor',
    surface_material   VARCHAR(100)    NULL,
    is_active          BOOLEAN         NOT NULL DEFAULT true,
    created_at         TIMESTAMP       NULL,
    updated_at         TIMESTAMP       NULL,
    FOREIGN KEY (venue_id)           REFERENCES venues(id)           ON DELETE CASCADE,
    FOREIGN KEY (sports_category_id) REFERENCES sports_categories(id) ON DELETE RESTRICT
);
```

##### `field_images`
```sql
-- Dipisah dari fields agar mendukung minimal 2 foto per lapangan
-- tanpa melanggar 1NF. is_primary digunakan untuk menentukan
-- foto yang tampil di katalog.
CREATE TABLE field_images (
    id         BIGINT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    field_id   BIGINT UNSIGNED  NOT NULL,
    image_path VARCHAR(255)     NOT NULL,
    is_primary BOOLEAN          NOT NULL DEFAULT false,
    sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP        NULL,
    updated_at TIMESTAMP        NULL,
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
```

##### `field_operating_hours`
```sql
-- 1 lapangan → 7 baris (satu per hari).
-- UNIQUE KEY mencegah duplikasi hari yang sama per lapangan.
CREATE TABLE field_operating_hours (
    id          BIGINT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    field_id    BIGINT UNSIGNED  NOT NULL,
    day_of_week TINYINT UNSIGNED NOT NULL, -- 0=Minggu, 1=Senin, ..., 6=Sabtu
    open_time   TIME             NULL,
    close_time  TIME             NULL,
    is_open     BOOLEAN          NOT NULL DEFAULT true,
    created_at  TIMESTAMP        NULL,
    updated_at  TIMESTAMP        NULL,
    UNIQUE KEY  uq_field_day (field_id, day_of_week),
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
```

##### `field_pricing`
```sql
-- Harga dipisah dari fields (3NF): harga bergantung pada
-- day_type, bukan hanya pada field.
-- Logika penentuan day_type: sistem cek booking_date terhadap
-- public_holidays → jika cocok = 'holiday',
-- jika Sabtu/Minggu = 'weekend', selainnya = 'weekday'.
CREATE TABLE field_pricing (
    id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    field_id       BIGINT UNSIGNED NOT NULL,
    day_type       ENUM('weekday', 'weekend', 'holiday') NOT NULL,
    price_per_slot DECIMAL(12, 2)  NOT NULL CHECK (price_per_slot > 0),
    created_at     TIMESTAMP       NULL,
    updated_at     TIMESTAMP       NULL,
    UNIQUE KEY  uq_field_day_type (field_id, day_type),
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);
```

##### `bookings`
```sql
-- total_price menyimpan snapshot harga saat checkout (immutable).
-- Harga tidak akan berubah meski admin mengubah tarif lapangan
-- setelah booking dibuat.
CREATE TABLE bookings (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id      BIGINT UNSIGNED NOT NULL,
    field_id     BIGINT UNSIGNED NOT NULL,
    booking_date DATE            NOT NULL,
    total_slots  TINYINT UNSIGNED NOT NULL,
    total_price  DECIMAL(12, 2)  NOT NULL,
    status       ENUM('pending', 'paid', 'completed', 'cancelled', 'expired')
                 NOT NULL DEFAULT 'pending',
    notes        TEXT            NULL,
    expires_at   TIMESTAMP       NULL, -- deadline bayar; diset BookingService
    created_at   TIMESTAMP       NULL,
    updated_at   TIMESTAMP       NULL,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE RESTRICT,
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE RESTRICT
);
```

##### `booking_slots`
```sql
-- Detail slot per booking. UNIQUE KEY uq_slot adalah "kunci ganda"
-- pencegah double-booking di level database, sebagai jaring pengaman
-- selain lockForUpdate() di BookingService.
CREATE TABLE booking_slots (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id   BIGINT UNSIGNED NOT NULL,
    field_id     BIGINT UNSIGNED NOT NULL,
    booking_date DATE            NOT NULL,
    start_time   TIME            NOT NULL,
    end_time     TIME            NOT NULL,
    created_at   TIMESTAMP       NULL,
    updated_at   TIMESTAMP       NULL,
    UNIQUE KEY  uq_slot (field_id, booking_date, start_time),
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id)   REFERENCES fields(id)   ON DELETE RESTRICT
);
```

##### `payments`
```sql
-- UNIQUE KEY uq_pay_booking memastikan 1 booking = 1 record payment.
-- reference_code adalah ID unik dari gateway / simulasi.
CREATE TABLE payments (
    id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id     BIGINT UNSIGNED NOT NULL,
    amount         DECIMAL(12, 2)  NOT NULL,
    method         VARCHAR(50)     NOT NULL,
    status         ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending',
    paid_at        TIMESTAMP       NULL,
    reference_code VARCHAR(100)    NOT NULL UNIQUE,
    created_at     TIMESTAMP       NULL,
    updated_at     TIMESTAMP       NULL,
    UNIQUE KEY  uq_pay_booking (booking_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE RESTRICT
);
```

##### `reviews`
```sql
-- Review dilekatkan ke Venue (bukan Field) karena user menilai
-- pengalaman keseluruhan tempat. field_id (nullable) tersedia
-- untuk referensi lapangan spesifik yang dimainkan.
-- UNIQUE KEY uq_user_booking: 1 booking hanya boleh menghasilkan
-- 1 ulasan. Booking harus berstatus 'completed' — di-enforce
-- oleh application layer (ReviewController/Policy).
-- Observer/Trigger memperbarui venues.rating_avg dan review_count
-- setiap kali review baru di-INSERT atau di-UPDATE.
CREATE TABLE reviews (
    id         BIGINT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    user_id    BIGINT UNSIGNED  NOT NULL,
    venue_id   BIGINT UNSIGNED  NOT NULL,
    field_id   BIGINT UNSIGNED  NULL,
    booking_id BIGINT UNSIGNED  NOT NULL,
    rating     TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment    TEXT             NULL,
    created_at TIMESTAMP        NULL,
    updated_at TIMESTAMP        NULL,
    UNIQUE KEY  uq_user_booking (booking_id),
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE RESTRICT,
    FOREIGN KEY (venue_id)   REFERENCES venues(id)   ON DELETE CASCADE,
    FOREIGN KEY (field_id)   REFERENCES fields(id)   ON DELETE SET NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE RESTRICT
);
```

---

## 5. Struktur Proyek Laravel

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                          ← Login, Register (Breeze)
│   │   │   ├── VenueController.php            ← Halaman publik venue
│   │   │   ├── FieldController.php            ← Halaman publik field-detail
│   │   │   ├── BookingController.php          ← Checkout, riwayat, batal
│   │   │   ├── PaymentController.php          ← Simulasi pembayaran
│   │   │   ├── DashboardController.php        ← Dashboard user
│   │   │   ├── ReviewController.php           ← Submit ulasan
│   │   │   └── Admin/
│   │   │       ├── AdminDashboardController.php
│   │   │       ├── AdminVenueController.php   ← Super-admin: CRUD venue + assign admin
│   │   │       │                                 Admin: edit venue milik sendiri
│   │   │       ├── AdminFieldController.php   ← Admin: CRUD field di venue sendiri
│   │   │       ├── AdminFieldImageController.php
│   │   │       ├── AdminFacilityController.php      ← Super-admin only
│   │   │       ├── AdminBookingController.php        ← Super-admin: semua; Admin: venue sendiri
│   │   │       ├── AdminSportsCategoryController.php ← Super-admin only
│   │   │       └── AdminPublicHolidayController.php  ← Super-admin only
│   │   ├── Middleware/
│   │   │   ├── IsAdminOrSuperAdmin.php   ← Proteksi semua rute /admin/*
│   │   │   └── IsSuperAdmin.php          ← Proteksi rute eksklusif super-admin
│   │   └── Requests/
│   │       ├── StoreBookingRequest.php
│   │       ├── StoreVenueRequest.php
│   │       └── StoreFieldRequest.php
│   ├── Models/
│   │   ├── User.php               ← + relasi hasOne(Venue) + helper isSuperAdmin/isAdmin
│   │   ├── Venue.php              ← + relasi belongsTo(User, 'admin_id')
│   │   ├── Field.php
│   │   ├── FieldImage.php
│   │   ├── FieldOperatingHour.php
│   │   ├── FieldPricing.php
│   │   ├── SportsCategory.php
│   │   ├── Facility.php
│   │   ├── PublicHoliday.php
│   │   ├── Booking.php
│   │   ├── BookingSlot.php
│   │   ├── Payment.php
│   │   └── Review.php
│   ├── Policies/                  ← Otorisasi berbasis ownership
│   │   ├── VenuePolicy.php        ← Cek venues.admin_id === auth()->id()
│   │   └── FieldPolicy.php        ← Cek field->venue->admin_id === auth()->id()
│   ├── Services/
│   │   └── BookingService.php     ← Checkout atomik: lockForUpdate + DB::transaction
│   └── Jobs/
│       ├── ExpireUnpaidBookings.php
│       └── CompleteFinishedBookings.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── SuperAdminUserSeeder.php  ← 1 akun super-admin
│       ├── AdminUserSeeder.php       ← Akun admin per venue
│       ├── SportsCategorySeeder.php
│       ├── FacilitySeeder.php
│       ├── PublicHolidaySeeder.php
│       ├── VenueSeeder.php
│       └── FieldSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php         ← Layout publik (navbar + footer)
│   │   │   └── admin.blade.php       ← Layout dashboard admin/super-admin (sidebar)
│   │   ├── components/
│   │   │   └── ui/
│   │   │       ├── button.blade.php
│   │   │       ├── card.blade.php
│   │   │       ├── badge.blade.php
│   │   │       └── modal.blade.php   ← Komponen modal Alpine.js reusable
│   │   ├── auth/
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── venue-catalog.blade.php
│   │   │   ├── venue-detail.blade.php
│   │   │   └── field-detail.blade.php  ← Kalender slot interaktif
│   │   ├── dashboard/                  ← Area user
│   │   │   ├── index.blade.php
│   │   │   ├── bookings/
│   │   │   ├── payments/
│   │   │   └── reviews/
│   │   ├── admin/                      ← Area admin & super-admin
│   │   │   ├── dashboard.blade.php
│   │   │   ├── venues/
│   │   │   │   └── fields/             ← Manajemen field di dalam venue
│   │   │   ├── facilities/
│   │   │   ├── categories/
│   │   │   ├── holidays/
│   │   │   └── bookings/
│   │   └── errors/
│   │       ├── 404.blade.php           ← "Bola Keluar Garis!"
│   │       └── 403.blade.php           ← "Area Terbatas"
│   └── js/
│       ├── app.js
│       └── calendar.js                 ← Logika kalender slot (Alpine + Fetch)
├── routes/
│   ├── web.php
│   └── api.php                         ← Endpoint JSON slot availability & harga
└── config/
    └── booking.php                     ← Konfigurasi: durasi slot, batas expiry, dll
```

---

## 6. Struktur Website (Sitemap Lengkap)

### Area Publik

| Path | Halaman | Komponen Utama |
| --- | --- | --- |
| `/` | Beranda | Hero, Keunggulan (3 kolom), Venue Populer |
| `/venues` | Katalog Venue | Filter sidebar (kota, kategori olahraga), Card grid, Pagination |
| `/venues/{slug}` | Detail Venue | Info venue, daftar field, rating & ulasan |
| `/fields/{slug}` | Detail Field | Galeri foto, info lapangan, Kalender Slot Interaktif |
| `/login` | Login | Form auth |
| `/register` | Registrasi | Form registrasi |

### Area User (`/dashboard`)

| Path | Halaman |
| --- | --- |
| `/dashboard` | Dashboard (ringkasan aktivitas, booking aktif) |
| `/dashboard/booking/confirm` | Konfirmasi Booking (ringkasan + total harga) |
| `/dashboard/bookings` | Riwayat Booking (filter: Aktif / Selesai / Dibatalkan / Kedaluwarsa) |
| `/dashboard/bookings/{id}` | Detail Transaksi + Invoice |
| `/dashboard/payments/{id}` | Simulasi Pembayaran + Countdown Timer |
| `/dashboard/reviews/create?booking={id}` | Form Ulasan (hanya untuk booking `completed`) |

### Area Admin Venue (`/admin`) — diakses Admin & Super-Admin

| Path | Halaman | Akses |
| --- | --- | --- |
| `/admin/dashboard` | Dashboard (metrik venue sendiri) | Admin + Super-Admin |
| `/admin/my-venue` | Edit profil Venue milik sendiri | Admin only |
| `/admin/fields` | Daftar Field di Venue sendiri | Admin + Super-Admin |
| `/admin/fields/create` | Tambah Field baru | Admin + Super-Admin |
| `/admin/fields/{id}/edit` | Edit Field (Policy cek ownership) | Admin + Super-Admin |
| `/admin/my-bookings` | Pantau booking masuk ke Venue sendiri | Admin + Super-Admin |

### Area Super-Admin (`/admin`) — eksklusif Super-Admin

| Path | Halaman |
| --- | --- |
| `/admin/venues` | Daftar semua Venue |
| `/admin/venues/create` | Buat Venue baru |
| `/admin/venues/{id}/edit` | Edit Venue manapun |
| `/admin/venues/{id}/assign-admin` | Assign akun Admin ke Venue |
| `/admin/categories` | Manajemen Kategori Olahraga |
| `/admin/facilities` | Manajemen Fasilitas |
| `/admin/holidays` | Manajemen Hari Libur Nasional |
| `/admin/bookings` | Pantau semua transaksi booking |

### Halaman Utilitas

| Path | Halaman |
| --- | --- |
| `*` (404) | Not Found — "Bola Keluar Garis!" |
| Akses terlarang | Forbidden 403 — "Area Terbatas" |

### API Internal (JSON)

| Endpoint | Deskripsi |
| --- | --- |
| `GET /api/fields/{field}/slots?date=YYYY-MM-DD` | Ketersediaan slot + harga dinamis per tanggal |

---

## 7. Alur Konversi (User Journey)

### 7.1 Guest → Registered User

```
Landing Page
  → [CTA: "Mulai Booking"] → Katalog Venue
  → Klik Venue → Detail Venue (daftar field tersedia)
  → Klik Field → Detail Field + Kalender Slot
  → Pilih slot → REDIRECT ke /login
  → Login / Register → Kembali ke Detail Field (redirect_back)
```

### 7.2 User → Paid Booking

```
Detail Field (/fields/{slug})
  → Pilih tanggal → API fetch slot secara real-time
  → Pilih slot (Alpine.js toggle, slot berubah warna)
     [Tersedia=hijau | Dipilih=biru | Tidak Tersedia=abu]
  → Sticky button: "Lanjut Konfirmasi (N Slot)" muncul
  → /dashboard/booking/confirm
     (ringkasan: field, venue, tanggal, slot, total harga)
  → Klik "Proses ke Pembayaran"
  → /dashboard/payments/{booking}
     (simulasi gateway + countdown timer expires_at)
  → Klik "Bayar Sekarang"
     → BookingService: update status → 'paid'
     → Buat record payments (status: success)
     → Redirect ke invoice /dashboard/bookings/{id}
```

### 7.3 Manajemen Pasca-Transaksi (User)

```
/dashboard/bookings
  → Filter: Aktif / Selesai / Dibatalkan / Kedaluwarsa
  → Per baris: [Lihat Invoice] [Bayar Tagihan] [Batalkan]
  → Batalkan: modal konfirmasi Alpine.js
    → PATCH /bookings/{id}/cancel
    → Slot dihapus dari booking_slots (kembali tersedia)

  → Booking berstatus 'completed':
    → Tombol [Beri Ulasan] muncul
    → /dashboard/reviews/create?booking={id}
    → Rating bintang (Alpine.js) + komentar opsional
    → Observer update venues.rating_avg & review_count
```

### 7.4 Alur Super-Admin: Onboarding Venue Baru

```
Super-Admin Login → /admin/dashboard

Membuat Venue:
  → /admin/venues/create
  → Isi data venue (nama, alamat, kebijakan, logo, dsb.)
  → Centang Fasilitas & Kategori Olahraga dari master data
  → [Simpan] → Venue terbuat, admin_id = NULL (unassigned)

Assign Admin ke Venue:
  → /admin/venues/{id}/assign-admin
  → Dropdown: pilih dari akun ber-role 'admin'
    yang belum memiliki venue (WHERE admin_id IS NULL)
  → [Assign] → venues.admin_id = user.id
  → Admin tersebut kini dapat login dan mengelola venue-nya
```

### 7.5 Alur Admin Venue: Kelola Lapangan

```
Admin Login → /admin/dashboard
  (dashboard otomatis ter-scope ke venue miliknya)

Edit Profil Venue:
  → /admin/my-venue
  → Edit deskripsi, aturan, kebijakan, logo, fasilitas

Tambah Lapangan Baru:
  → /admin/fields/create
  → Isi: nama, tipe (indoor/outdoor/semi-indoor), material
  → Upload minimal 2 foto → set foto utama (is_primary)
  → Atur jam operasional 7 hari
     (Alpine.js toggle is_open per hari)
  → Atur harga: Weekday / Weekend / Holiday
  → [Simpan] → Field terdaftar di venue-nya

Edit Lapangan:
  → /admin/fields/{id}/edit
  → FieldPolicy cek: field->venue->admin_id === auth()->id()
  → ❌ Jika bukan miliknya → 403 Forbidden
  → ✅ Jika miliknya → lanjut ke form edit

Pantau Booking:
  → /admin/my-bookings
  → Tampil HANYA booking untuk field-field di venue sendiri
```
