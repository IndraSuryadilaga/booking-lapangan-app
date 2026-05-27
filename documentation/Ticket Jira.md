# 📋 Daftar Tiket Jira - Sistem Booking Lapangan

Dokumen ini berisi rincian tugas (backlog) untuk pengembangan sistem booking lapangan, dibagi menjadi empat Epic utama: Database, Backend, API, dan Frontend.

---

## 🗄️ EPIC DB — Fondasi Database

### SCRUM-DB-01 · db/references
**Judul:** Skema & Seeder untuk Tabel Referensi Master  
**Assignee:** Orlando Sugian | **SP:** 2 | **Dependencies:** —  
**Deskripsi:**  
Membuat fondasi data master yang menjadi referensi seluruh modul sistem. Tiga tabel ini tidak memiliki Foreign Key ke tabel lain, sehingga harus di-migrate pertama kali.

**Langkah Teknis:**
1. Buat & jalankan migration `create_sports_categories_table`:
   - `id`, `name` (VARCHAR 100), `slug` (VARCHAR 110 UNIQUE), `icon` (VARCHAR 255 NULL), `is_active` (BOOLEAN DEFAULT true), `timestamps`.
2. Buat & jalankan migration `create_facilities_table`:
   - `id`, `name` (VARCHAR 100 UNIQUE), `icon` (VARCHAR 255 NULL), `timestamps`.
3. Buat & jalankan migration `create_public_holidays_table`:
   - `id`, `holiday_date` (DATE UNIQUE), `name` (VARCHAR 150), `timestamps`.
4. Buat `SportsCategorySeeder` → data awal: Futsal, Basket, Badminton, Voli, Tenis Meja.
5. Buat `FacilitySeeder` → data awal: Parkir Luas, Ruang Ganti, Toilet, Mushola, Kantin, Tribun.
6. Buat `PublicHolidaySeeder` → isi 5 hari libur nasional terdekat untuk keperluan demo.
7. Daftarkan ketiga seeder di `DatabaseSeeder.php`.

**Acceptance Criteria:**
- [ ] Ketiga tabel berhasil di-migrate tanpa error.
- [ ] Seeder mengisi data awal yang bisa dipakai modul lain.
- [ ] Tidak ada Foreign Key di ketiga tabel ini (zero dependency).

---

### SCRUM-DB-02 · db/users
**Judul:** Skema Tabel Users dengan Multi-Role & Seeder  
**Assignee:** Orlando Sugian | **SP:** 2 | **Dependencies:** —  
**Deskripsi:**  
Memperluas migration default Laravel Breeze untuk menambahkan kolom role, phone, dan avatar sesuai skema v3.0 dengan tiga level role.

**Langkah Teknis:**
1. Modifikasi migration `create_users_table`:
   - `role` ENUM('user', 'admin', 'super-admin') DEFAULT 'user'.
   - `phone` VARCHAR(20) NULL.
   - `avatar` VARCHAR(255) NULL.
2. Buat `SuperAdminUserSeeder`:
   - `superadmin@booking.com` / `password`.
3. Buat `AdminUserSeeder` → 2 akun admin (untuk 2 venue demo).
4. Buat `UserSeeder` → 3 akun user biasa untuk demo booking.
5. Daftarkan di `DatabaseSeeder.php` dengan urutan: SuperAdmin → Admin → User.

**Acceptance Criteria:**
- [ ] Tabel users memiliki kolom role, phone, avatar.
- [ ] Tiga level role tersedia dalam ENUM.
- [ ] `php artisan db:seed` menghasilkan data semua role tanpa error.

---

### SCRUM-DB-03 · db/venues
**Judul:** Skema Venues, Pivot Tables, & Seeder  
**Assignee:** Orlando Sugian | **SP:** 3 | **Dependencies:** db/references, db/users  
**Deskripsi:**  
Membuat tabel venues beserta dua tabel pivot many-to-many dengan referensi ke sports_categories dan facilities.

**Langkah Teknis:**
1. Buat migration `create_venues_table`:
   - `admin_id` (FK users, ON DELETE SET NULL), `UNIQUE KEY uq_venue_admin`.
   - Kolom cache: `rating_avg` (DECIMAL 3,2), `review_count` (INT).
2. Buat migration `create_venue_sport_categories_table` (pivot).
3. Buat migration `create_venue_facilities_table` (pivot).
4. Buat `VenueSeeder` → 2 venue demo (assign ke akun admin), lengkap dengan data pivot.

**Acceptance Criteria:**
- [ ] Ketiga tabel berhasil di-migrate.
- [ ] `UNIQUE KEY uq_venue_admin` berfungsi (1 admin = 1 venue).
- [ ] ON DELETE SET NULL pada `admin_id` terbukti berfungsi.

---

### SCRUM-DB-04 · db/fields
**Judul:** Skema Fields Module (Field, Images, Hours, Pricing) & Seeder  
**Assignee:** Ndzul | **SP:** 4 | **Dependencies:** db/venues  
**Deskripsi:**  
Membuat empat tabel modul Field: data utama lapangan, galeri foto, jam operasional, dan skema harga dinamis.

**Langkah Teknis:**
1. Buat migration `create_fields_table` (FK venues & sports_categories).
2. Buat migration `create_field_images_table` (FK fields).
3. Buat migration `create_field_operating_hours_table` (Unique: field_id + day_of_week).
4. Buat migration `create_field_pricing_table` (Unique: field_id + day_type).
5. Buat `FieldSeeder` → minimal 2 lapangan per venue, lengkap dengan jam & harga.

**Acceptance Criteria:**
- [ ] Keempat tabel berhasil di-migrate tanpa FK conflict.
- [ ] Unique keys mencegah duplikasi hari/tipe harga per lapangan.

---

### SCRUM-DB-05 · db/transactions-reviews
**Judul:** Skema Tabel Transaksi & Reviews  
**Assignee:** Orlando Sugian | **SP:** 4 | **Dependencies:** db/fields, db/users  
**Deskripsi:**  
Membuat tabel operasional inti: booking, slot detail, pembayaran, dan ulasan.

**Langkah Teknis:**
1. Buat migration `create_bookings_table` (status: pending, paid, completed, cancelled, expired).
2. Buat migration `create_booking_slots_table` (Unique: field_id, booking_date, start_time).
3. Buat migration `create_payments_table` (Unique: booking_id).
4. Buat migration `create_reviews_table` (Unique: booking_id).
5. Definisikan relasi Eloquent di masing-masing Model.

**Acceptance Criteria:**
- [ ] `uq_slot` mencegah double booking di level database.
- [ ] Relasi Eloquent dapat dipanggil tanpa error.

---

## ⚙️ EPIC BE — Backend & Logika Bisnis

### SCRUM-BE-01 · be/auth-middleware
**Judul:** Setup Auth: Model User Helpers & Middleware Proteksi Rute  
**Assignee:** Indra Suryadilaga | **SP:** 3 | **Dependencies:** db/users  

**Langkah Teknis:**
1. Install Laravel Breeze (Blade).
2. Tambahkan helper methods di `User.php`: `isSuperAdmin()`, `isAdmin()`, `isUser()`.
3. Buat middleware `IsAdminOrSuperAdmin` dan `IsSuperAdmin`.
4. Daftarkan alias middleware di `bootstrap/app.php`.
5. Terjemahkan view auth ke Bahasa Indonesia.

---

### SCRUM-BE-02 · be/master-data
**Judul:** Model & Admin Controller untuk Data Master Referensi  
**Assignee:** Indra Suryadilaga | **SP:** 3 | **Dependencies:** db/references, be/auth-middleware  

**Langkah Teknis:**
1. Buat Model `SportsCategory`, `Facility`, `PublicHoliday`.
2. Buat Resource Controller untuk masing-masing di folder `Admin/`.
3. Implementasi logika: auto-slug, validasi unik, dan proteksi penghapusan jika data digunakan.

---

### SCRUM-BE-03 · be/venues
**Judul:** Model Venue, Controller Publik & Admin, VenuePolicy  
**Assignee:** Indra Suryadilaga | **SP:** 5 | **Dependencies:** db/venues, be/auth-middleware  

**Langkah Teknis:**
1. Buat Model `Venue` dengan relasi dan Accessor logo.
2. Buat `VenueController` (Publik) untuk katalog dan detail.
3. Buat `AdminVenueController` dengan fitur `assignAdmin` (khusus Super-Admin).
4. Implementasi `VenuePolicy` untuk membatasi akses edit hanya ke pemilik venue.

---

### SCRUM-BE-04 · be/fields
**Judul:** Model Field Module, Controller Publik & Admin, FieldPolicy  
**Assignee:** Ndzul | **SP:** 6 | **Dependencies:** db/fields, be/venues  

**Langkah Teknis:**
1. Buat Model `Field` beserta relasi ke Images, Hours, dan Pricing.
2. Buat `AdminFieldController` menggunakan `DB::transaction()` untuk simpan data atomik.
3. Buat `AdminFieldImageController` untuk upload multiple file dan set foto utama.
4. Implementasi `FieldPolicy`.

---

### SCRUM-BE-05 · be/booking-core
**Judul:** BookingService, BookingController & Admin Booking  
**Assignee:** Indra Suryadilaga | **SP:** 8 | **Dependencies:** db/transactions-reviews, be/fields  

**Langkah Teknis:**
1. Buat `BookingService.php` dengan logika **Pessimistic Locking** (`lockForUpdate()`) untuk mencegah race condition.
2. Buat `BookingController` untuk alur checkout user.
3. Buat `AdminBookingController` untuk manajemen status oleh pengelola.

---

### SCRUM-BE-06 · be/payments-background-jobs
**Judul:** PaymentController, Job Expiry & Job Completion  
**Assignee:** Ndzul | **SP:** 5 | **Dependencies:** be/booking-core  

**Langkah Teknis:**
1. Buat `PaymentController` untuk simulasi proses bayar.
2. Buat Job `ExpireUnpaidBookings` (menghapus slot jika waktu bayar habis).
3. Buat Job `CompleteFinishedBookings` (update status ke completed otomatis).
4. Daftarkan di `Schedule` (scheduler).

---

### SCRUM-BE-07 · be/reviews-dashboard
**Judul:** ReviewController, Model Review, Observer & DashboardController  
**Assignee:** Indra Suryadilaga | **SP:** 4 | **Dependencies:** be/payments-background-jobs  

**Langkah Teknis:**
1. Buat `ReviewObserver` untuk update otomatis `rating_avg` di tabel venues.
2. Buat `ReviewController` dengan validasi: hanya untuk booking yang sudah `completed`.
3. Buat `DashboardController` untuk statistik user dan admin.

---

## 🔌 EPIC API — Endpoint JSON

### SCRUM-API-01 · api/booking-slots
**Judul:** Endpoint Ketersediaan Slot & Harga Dinamis  
**Assignee:** Indra Suryadilaga | **SP:** 5 | **Dependencies:** be/fields, db/transactions-reviews  

**Langkah Teknis:**
1. Buat `SlotAvailabilityController`.
2. Logika: Cek hari libur → Tentukan tipe harga → Generate slot jam operasional → Filter slot yang sudah terpesan.
3. Return JSON format untuk dikonsumsi Alpine.js.

---

## 🎨 EPIC FE — Frontend & Antarmuka

### SCRUM-FE-01 · fe/layouts-components
**Judul:** Layout Master & Komponen UI Reusable  
**Assignee:** Indra Suryadilaga | **SP:** 5 | **Dependencies:** be/auth-middleware  

**Langkah Teknis:**
1. Konfigurasi Tailwind CSS v4.
2. Buat Layout `app.blade.php` (Publik) dan `admin.blade.php` (Dashboard).
3. Buat komponen Blade: `button`, `card`, `badge`, `modal`.

---

### SCRUM-FE-02 · fe/public-catalog
**Judul:** Halaman Beranda, Katalog Venue & Detail Venue  
**Assignee:** Anggota B | **SP:** 6 | **Dependencies:** fe/layouts-components, be/venues  

**Langkah Teknis:**
1. `home.blade.php`: Hero section & venue populer.
2. `venue-catalog.blade.php`: Sidebar filter & grid venue.
3. `venue-detail.blade.php`: Info venue, list lapangan, dan ulasan.

---

### SCRUM-FE-03 · fe/field-calendar
**Judul:** Halaman Detail Field & Kalender Slot Interaktif  
**Assignee:** Indra Suryadilaga | **SP:** 8 | **Dependencies:** fe/public-catalog, api/booking-slots  

**Langkah Teknis:**
1. Implementasi Alpine.js untuk fetch data slot dari API secara dinamis.
2. Logika seleksi multiple slot dan kalkulasi harga real-time di frontend.
3. Feedback visual untuk slot: tersedia, dipilih, terpesan, atau tutup.

---

### SCRUM-FE-04 · fe/user-portal
**Judul:** Dashboard, Riwayat Booking, Pembayaran & Ulasan (User Area)  
**Assignee:** Anggota B | **SP:** 7 | **Dependencies:** fe/field-calendar, be/booking-core  

**Langkah Teknis:**
1. Halaman Riwayat Booking dengan filter status.
2. Halaman Pembayaran dengan countdown timer.
3. Form ulasan interaktif (rating bintang).

---

### SCRUM-FE-05 · fe/admin-portal
**Judul:** Dashboard Admin, Manajemen Venue, Field & Data Master (Admin Area)  
**Assignee:** Indra Suryadilaga | **SP:** 8 | **Dependencies:** fe/layouts-components, be/venues, be/fields  

**Langkah Teknis:**
1. Dashboard statistik (Stat cards & Chart).
2. CRUD Venue & Field (dengan toggle jam operasional Alpine.js).
3. Manajemen data master (khusus Super-Admin).

---

### SCRUM-FE-06 · fe/error-pages
**Judul:** Halaman Error 404 & 403 + Seeder Demo  
**Assignee:** Anggota B | **SP:** 2 | **Dependencies:** fe/layouts-components  

**Langkah Teknis:**
1. Kustomisasi halaman 404 dan 403.
2. Buat `DemoDataSeeder` untuk mempermudah presentasi (sekali perintah isi semua data).
