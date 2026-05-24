# Backlog Proyek: Sistem Booking Lapangan

---

## Epic 1: Infrastruktur Dasar & Autentikasi

### **Task 1: Setup Proyek & Environment**
- **ID**: `feature/01-setup-base`
- **Deskripsi**: Membuat proyek Laravel 13 baru, mengintegrasikan Tailwind CSS v4, Alpine.js, dan Vite.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Jalankan `composer create-project laravel/laravel .`
2. Instal dependensi frontend: `npm install -D tailwindcss postcss autoprefixer alpinejs`
3. Inisialisasi konfigurasi: `npx tailwindcss init -p`
4. Konfigurasikan `tailwind.config.js` dan `resources/css/app.css`.
5. Buat layout master `resources/views/layouts/app.blade.php` yang memanggil direktif `@vite()`.

**Acceptance Criteria:**
- [ ] Proyek berhasil di-clone dan dijalankan oleh anggota tim lain.
- [ ] Halaman welcome Laravel menampilkan gaya dari Tailwind dan interaksi dari Alpine.js.

---

### **Task 2: Setup Database & User Role**
- **ID**: `feature/02-setup-db-users`
- **Deskripsi**: Mengonfigurasi database MySQL dan menambahkan kolom `role` pada tabel `users`.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Konfigurasikan koneksi database di file `.env`.
2. Modifikasi migration `create_users_table.php` untuk menambahkan kolom `role` dengan tipe `ENUM('user', 'admin')` dan default `'user'`.
3. Buat `UserSeeder` untuk menambahkan 1 akun Admin dan 1 akun User.
4. Jalankan `php artisan migrate --seed`.

**Acceptance Criteria:**
- [ ] Migrasi berjalan tanpa error.
- [ ] Tabel `users` di database memiliki kolom `role` dan berisi data dari seeder.

---

### **Task 3: Implementasi Autentikasi**
- **ID**: `feature/03-setup-breeze`
- **Deskripsi**: Menginstal Laravel Breeze untuk fungsionalitas Register, Login, dan Logout.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Jalankan `composer require laravel/breeze --dev`.
2. Jalankan `php artisan breeze:install blade`.
3. (Opsional) Terjemahkan teks UI di `resources/views/auth/` ke Bahasa Indonesia.

**Acceptance Criteria:**
- [ ] Pengguna dapat mendaftar dan datanya tersimpan di database.
- [ ] Pengguna dapat login dan diarahkan ke `/dashboard`.
- [ ] Pengguna dapat logout.

---

### **Task 4: Middleware & Proteksi Rute Admin**
- **ID**: `feature/04-middleware-admin`
- **Deskripsi**: Membuat middleware `IsAdmin` untuk melindungi rute-rute khusus admin.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Buat middleware `php artisan make:middleware IsAdmin`.
2. Implementasikan logika di `app/Http/Middleware/IsAdmin.php` untuk memeriksa `auth()->user()->role === 'admin'`.
3. Daftarkan middleware di `bootstrap/app.php`.
4. Buat rute `/admin/test` yang dibungkus oleh middleware ini untuk pengujian.

**Acceptance Criteria:**
- [ ] Akun `user` menerima response 403 (Forbidden) saat mengakses `/admin/test`.
- [ ] Akun `admin` berhasil mengakses `/admin/test`.

### **Task 5: Implementasi Base UI Components & Design System**
- **ID**: `feature/05-design-system`
- **Deskripsi**: Membuat standarisasi identitas visual ke dalam proyek berdasarkan Design Guideline.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Konfigurasi Warna: Update resources/css/app.css untuk mendefinisikan variabel warna primer (Green/Emerald), sekunder (Indigo/Dark), dan aksen sesuai dokumen panduan.
2. Base Layout: Modifikasi resources/views/components/layout.blade.php agar mencerminkan prinsip "Modern & Efisien" (Background neutral, tipografi bersih).
3. Pembuatan Komponen Blade: Buat folder resources/views/components/ui/ dan buat komponen dasar berikut:
    - button.blade.php: Mendukung varian primary, secondary, dan outline.
    - card.blade.php: Kartu dengan shadow tipis dan border halus untuk katalog lapangan.
    - badge.blade.php: Untuk penanda status (Tersedia, Penuh, Booking).
4. Halaman Styleguide: Buat satu rute sementara /styleguide untuk mendemokan semua komponen tersebut dalam satu halaman.

**Acceptance Criteria:**
- [ ] Palet warna di app.css sesuai dengan identitas "Energik & Terpercaya".
- [ ] Komponen Button memiliki hover state dan active state yang konsisten.
- [ ] Layout utama sudah bersifat Mobile-first (Responsif di layar HP).
- [ ] Halaman /styleguide menampilkan semua elemen UI yang telah dibuat.
---

### **Task 6: Update Navigasi, Dashboard, & Test Refactoring**
- **ID**: `feature/06-auth-ui-refactor`
- **Deskripsi**: Menyesuaikan navigasi untuk berbagai role, memutakhirkan tampilan dashboard, dan memperbarui assertions pada test.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Modifikasi `layouts.navigation`: Tampilkan menu "Kelola Lapangan" hanya untuk Admin dan "Riwayat Booking" untuk User.
2. Update `dashboard.blade.php`: Tambahkan ringkasan statistik (misal: jumlah booking aktif).
3. Tambahkan rute `Route::resource('bookings', BookingController::class)` di `web.php`.
4. Refaktor `tests/Feature/Auth/RegistrationTest.php` dan `AuthenticationTest.php` agar mencakup pengecekan kolom `role`.

**Acceptance Criteria:**
- [ ] Navbar menampilkan link yang relevan sesuai role yang sedang login.
- [ ] Pengguna baru secara otomatis memiliki role `user` dan terverifikasi di unit test.
- [ ] Rute booking dapat diakses oleh user terautentikasi.

---

## Epic 2: Manajemen Data Master (Admin)

### **Task 1: Setup Database Kategori Olahraga**
- **ID**: `feature/07-db-sports-categories`
- **Deskripsi**: Membuat migrasi, model, dan seeder untuk tabel `sports_categories`.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Buat migration `create_sports_categories_table` (id, name, slug, icon).
2. Buat model `SportsCategory`.
3. Buat `SportsCategorySeeder` dengan data contoh (Futsal, Badminton, Basket).

**Acceptance Criteria:**
- [ ] Tabel `sports_categories` tersedia di database.
- [ ] Model dapat berinteraksi dengan tabel dan seeder berhasil dijalankan.

---

### **Task 2: CRUD Kategori Olahraga**
- **ID**: `feature/08-crud-categories`
- **Deskripsi**: Membangun fitur CRUD untuk mengelola `sports_categories` di dashboard admin.
- **Assignee**: Anggota B (Frontend/Fullstack)
- **Dependencies**: `feature/07-db-sports-categories`

**Langkah Teknis:**
1. Buat `AdminSportsCategoryController` di `app/Http/Controllers/Admin/`.
2. Implementasikan metode `index`, `create`, `store`, `edit`, `update`, `destroy`.
3. Buat view untuk daftar, form tambah, dan form edit di `resources/views/admin/categories/`.
4. Tambahkan validasi request untuk memastikan `name` unik dan wajib diisi.

**Acceptance Criteria:**
- [ ] Admin dapat menambah, melihat, mengubah, dan menghapus kategori.
- [ ] Terdapat *flash message* setelah setiap operasi CRUD.

---

### **Task 3: Setup Database Lapangan & Jam Operasional**
- **ID**: `feature/09-db-fields`
- **Deskripsi**: Membuat migrasi, model, dan seeder untuk `fields` dan `field_operating_hours`.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Buat migration `fields` (id, category_id, name, description, price_per_hour, image).
2. Buat migration `field_operating_hours` (field_id, day, open_time, close_time).
3. Definisikan relasi `hasMany` di model `Field`.

**Acceptance Criteria:**
- [ ] Skema database mendukung penyimpanan data lapangan beserta jam operasionalnya.

---

### **Task 4: CRUD Lapangan & Jam Operasional**
- **ID**: `feature/10-crud-fields`
- **Deskripsi**: Membangun fitur CRUD untuk `fields` termasuk upload foto dan pengaturan `field_operating_hours`.
- **Assignee**: Anda (Lead) atau Anggota B
- **Dependencies**: `feature/09-db-fields`

**Langkah Teknis:**
1. Buat `AdminFieldController` di `app/Http/Controllers/Admin/`.
2. Implementasikan logika upload foto menggunakan `Laravel Storage` dan jangan lupa `php artisan storage:link`.
3. Gunakan `DB::transaction()` untuk memastikan data `fields` dan `field_operating_hours` disimpan secara atomik.
4. Buat form dinamis di frontend untuk mengatur jam buka/tutup untuk 7 hari dalam seminggu.

**Acceptance Criteria:**
- [ ] Foto lapangan berhasil diunggah dan dapat diakses publik.
- [ ] Data lapangan dan 7 baris jam operasionalnya tersimpan bersamaan.
- [ ] Proses dibatalkan (rollback) jika salah satu penyimpanan (lapangan atau jam) gagal.

---

## Epic 3: Sistem Booking (Core Logic)

### **Task 1: Migration untuk bookings dan booking_slots**
- **ID**: `feature/11-db-bookings`
- **Deskripsi**: Membuat skema database untuk menyimpan data pesanan dan detail slot waktu yang dipesan.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Buat migration `bookings` (id, user_id, field_id, total_price, status [pending, paid, cancelled, expired, completed], booking_date).
2. Buat migration `booking_slots` (id, booking_id, start_time, end_time).
3. Tambahkan Unique Key `uq_slot` pada `booking_slots` yang menggabungkan `booking_id` (atau `field_id`), `booking_date`, dan `start_time` untuk mencegah double booking di level database.

**Acceptance Criteria:**
- [ ] Tabel `bookings` dan `booking_slots` berhasil dibuat.
- [ ] Constraint Unique Key mencegah duplikasi jadwal pada hari dan jam yang sama.

---

### **Task 2: API Ketersediaan Slot**
- **ID**: `feature/12-api-availability`
- **Deskripsi**: Membuat endpoint API untuk mengecek ketersediaan slot secara dinamis.
- **Assignee**: Anggota B (Fullstack)

**Langkah Teknis:**
1. Buat rute API `GET /api/fields/{field}/availability` di `routes/api.php`.
2. Buat `AvailabilityController` untuk menangani logika.
3. Logika: Ambil jam operasional, ambil slot yang sudah di-booking, lalu generate daftar slot beserta status ketersediaannya.
4. Kembalikan response JSON seperti `{"time": "09:00", "available": false}`.

**Acceptance Criteria:**
- [ ] Endpoint mengembalikan response JSON 200.
- [ ] Response berisi semua slot dari jam buka hingga tutup.
- [ ] Properti `available` bernilai `false` untuk slot yang sudah dipesan atau di luar jam operasional.

---

### **Task 3: Service & Validasi Booking**
- **ID**: `feature/13-booking-service`
- **Deskripsi**: Mengembangkan `BookingService` untuk menangani semua logika bisnis booking secara atomik.
- **Assignee**: Lead / Anggota A (Backend)

**Langkah Teknis:**
1. Buat `app/Services/BookingService.php`.
2. Buat metode `createBooking(User $user, Field $field, array $slots)`.
3. Bungkus semua logika dengan `DB::transaction()`.
4. Di dalam transaksi, gunakan `lockForUpdate()` pada slot yang akan dipesan untuk mencegah *race condition*.
5. Lakukan validasi (slot tersedia, dalam jam operasional, bukan waktu lampau).
6. Jika valid, buat data di tabel `bookings` dan `booking_slots`.

**Acceptance Criteria:**
- [ ] Memanggil `createBooking` dengan data valid akan menyimpan data ke database.
- [ ] Memanggil `createBooking` dengan slot yang sama secara bersamaan akan menyebabkan salah satunya gagal (melempar Exception).
- [ ] Tidak ada data "yatim" yang tersisa di database jika proses gagal di tengah jalan.

---

### **Task 4: UI Booking & Interaksi Pengguna**
- **ID**: `feature/14-ui-booking`
- **Deskripsi**: Membangun antarmuka halaman detail lapangan tempat pengguna memilih slot.
- **Assignee**: Anggota B (Frontend/Fullstack)

**Langkah Teknis:**
1. Buat view `resources/views/pages/field-detail.blade.php`.
2. Gunakan Alpine.js untuk mengelola state (tanggal terpilih, slot terpilih, total harga).
3. Panggil API dari **Task 7** saat tanggal diubah untuk me-render ulang daftar slot.
4. Beri style berbeda untuk slot yang tersedia, dipilih, dan tidak tersedia.
5. Tampilkan ringkasan pesanan (total slot, total harga) secara real-time.

**Acceptance Criteria:**
- [ ] Daftar slot diperbarui secara dinamis saat tanggal diubah tanpa refresh halaman.
- [ ] Slot yang tidak tersedia tidak dapat diklik.
- [ ] Total harga berubah secara otomatis saat pengguna memilih atau batal memilih slot.

---

## Epic 4: Transaksi & Otomatisasi

### **Task 1: Buat Migration dan relasi untuk payments**
- **ID**: `feature/15-db-payments`
- **Deskripsi**: Membuat skema database untuk menyimpan riwayat transaksi pembayaran.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Buat migration `payments` (id, booking_id, amount, payment_method, status, transaction_id).
2. Definisikan relasi `hasOne` atau `hasMany` pada model `Booking` ke `Payment`.
3. Tambahkan logic timestamps untuk mencatat waktu pembayaran.

**Acceptance Criteria:**
- [ ] Tabel `payments` tersedia di database dengan foreign key ke `bookings`.
- [ ] Relasi model Eloquent berfungsi dengan benar.

---

### **Task 2: Simulasi Sistem Pembayaran**
- **ID**: `feature/16-payment-system`
- **Deskripsi**: Membuat halaman simulasi pembayaran dan logika untuk mengubah status booking.
- **Assignee**: Anggota B (Fullstack)

**Langkah Teknis:**
1. Buat `PaymentController` dengan metode `show` dan `update`.
2. Buat view `resources/views/dashboard/payments/show.blade.php`.
3. Sediakan tombol "Bayar Sekarang" dan "Batalkan".
4. Logika `update`: Buat entri di tabel `payments`, lalu update status di tabel `bookings` menjadi `paid` atau `cancelled`.
5. Redirect pengguna ke halaman riwayat transaksi.

**Acceptance Criteria:**
- [ ] Menekan "Bayar Sekarang" mengubah status booking menjadi `paid`.
- [ ] Entri baru dibuat di tabel `payments` untuk setiap upaya transaksi.
- [ ] Pengguna mendapat feedback visual (pesan sukses/gagal) setelah aksi.

---

### **Task 3: Job Otomatisasi: Kedaluwarsa**
- **ID**: `feature/17-job-expiration`
- **Deskripsi**: Membuat job terjadwal untuk membatalkan booking yang tidak dibayar.
- **Assignee**: Anggota A (Backend)

**Langkah Teknis:**
1. Buat job `php artisan make:job ExpireUnpaidBookings`.
2. Logika di `handle()`: Cari booking `pending` yang dibuat lebih dari X menit/jam yang lalu, lalu ubah statusnya menjadi `expired`.
3. **Penting**: Hapus juga `booking_slots` terkait atau buat mekanisme agar slot tersebut tersedia kembali.
4. Daftarkan job di `app/Console/Kernel.php` untuk berjalan periodik (misal: `everyFiveMinutes()`).

**Acceptance Criteria:**
- [ ] Booking `pending` yang sudah lama otomatis berubah menjadi `expired`.
- [ ] Slot dari booking yang kedaluwarsa kembali tersedia untuk dipesan.

---

### **Task 4: Job Otomatisasi: Selesai**
- **ID**: `feature/18-job-completion`
- **Deskripsi**: Membuat job terjadwal untuk mengubah status booking yang telah selesai.
- **Assignee**: Anggota A (Backend)

**Langkah Teknis:**
1. Buat job `php artisan make:job CompleteFinishedBookings`.
2. Logika di `handle()`: Cari booking `paid` yang waktu bermainnya sudah lewat, lalu ubah statusnya menjadi `completed`.
3. Daftarkan job di `app/Console/Kernel.php` untuk berjalan periodik (misal: `hourly()`).

**Acceptance Criteria:**
- [ ] Booking `paid` yang sudah lewat jamnya otomatis berubah menjadi `completed`.
- [ ] Job tidak mengubah status booking selain `paid`.
