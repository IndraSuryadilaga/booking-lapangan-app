# Backlog Proyek: Sistem Booking Lapangan

---

## Epic 1: Infrastruktur Dasar & Autentikasi

### Task 1.1: Setup Proyek & Environment
- **ID**: `feature/01-setup-base`
- **Assignee**: **Kamu**
- **Story Points**: `3` — Tooling familiar, tapi mencakup dua layout (publik + admin) dan konfigurasi Vite + Tailwind.
  **Langkah Teknis:**
1. Jalankan `composer create-project laravel/laravel .`
2. Instal dependensi frontend: `npm install -D tailwindcss postcss autoprefixer alpinejs`
3. Inisialisasi konfigurasi: `npx tailwindcss init -p`
4. Konfigurasikan `tailwind.config.js` dan `resources/css/app.css`.
5. Buat layout master `resources/views/layouts/app.blade.php` yang memanggil direktif `@vite()`.
6. Buat layout admin `resources/views/layouts/admin.blade.php` dengan sidebar.
   **Acceptance Criteria:**
- [ ] Proyek berhasil di-clone dan dijalankan oleh semua anggota tim.
- [ ] Halaman welcome menampilkan gaya dari Tailwind dan interaksi dari Alpine.js.
- [ ] Dua layout utama (`app.blade.php` dan `admin.blade.php`) sudah tersedia.
---

### Task 1.2: Setup Database & Tabel Users
- **ID**: `feature/02-setup-db-users`
- **Assignee**: **Kamu**
- **Story Points**: `2` — Konfigurasi `.env` + revisi migration + dua seeder. Tidak ada logika kompleks.
  **Langkah Teknis:**
1. Konfigurasikan koneksi database di file `.env`.
2. Modifikasi migration `create_users_table.php` sesuai skema terbaru:
   ```sql
   id, name, email, password,
   role ENUM('user','admin') DEFAULT 'user',
   phone VARCHAR(20) NULL,
   avatar VARCHAR(255) NULL,
   email_verified_at, remember_token, timestamps
   ```
3. Buat `AdminUserSeeder` (1 akun Admin) dan `UserSeeder` (1 akun User biasa).
4. Jalankan `php artisan migrate --seed`.
   **Acceptance Criteria:**
- [ ] Migrasi berjalan tanpa error.
- [ ] Tabel `users` memiliki kolom `role`, `phone`, dan `avatar`.
- [ ] Database berisi data seed admin dan user.
---

### Task 1.3: Implementasi Autentikasi (Laravel Breeze)
- **ID**: `feature/03-setup-breeze`
- **Assignee**: **Kamu**
- **Story Points**: `2` — Mayoritas di-generate oleh Breeze. Effort utama: translasi UI dan tambah field `phone` di form registrasi.
  **Langkah Teknis:**
1. Jalankan `composer require laravel/breeze --dev`.
2. Jalankan `php artisan breeze:install blade`.
3. Terjemahkan teks UI di `resources/views/auth/` ke Bahasa Indonesia.
4. Sesuaikan form registrasi untuk menyertakan field `phone` (opsional).
   **Acceptance Criteria:**
- [ ] Pengguna dapat mendaftar, login, dan logout.
- [ ] Pengguna baru secara otomatis mendapat `role = 'user'`.
- [ ] Setelah login, pengguna diarahkan ke `/dashboard`.
---

### Task 1.4: Middleware & Proteksi Rute Admin
- **ID**: `feature/04-middleware-admin`
- **Assignee**: **Kamu**
- **Story Points**: `2` — Satu file middleware + registrasi di `bootstrap/app.php` + group rute. Scope kecil dan terdefinisi jelas.
  **Langkah Teknis:**
1. Buat middleware: `php artisan make:middleware IsAdmin`.
2. Implementasikan logika di `app/Http/Middleware/IsAdmin.php`:
   ```php
   if (auth()->user()?->role !== 'admin') {
       abort(403);
   }
   ```
3. Daftarkan middleware di `bootstrap/app.php`.
4. Proteksi semua rute group `/admin` dengan middleware ini.
   **Acceptance Criteria:**
- [ ] Akun `user` menerima response 403 saat mengakses rute `/admin/*`.
- [ ] Akun `admin` dapat mengakses semua rute `/admin/*`.
---

### Task 1.5: Implementasi Design System & UI Components
- **ID**: `feature/05-design-system`
- **Assignee**: **Kamu**
- **Story Points**: `5` — Empat komponen Blade reusable (button, card, badge, modal), CSS variables, dan halaman styleguide. Keputusan desain di sini berdampak ke seluruh proyek.
  **Langkah Teknis:**
1. Definisikan variabel warna (primary, secondary, aksen) di `resources/css/app.css`.
2. Buat folder `resources/views/components/ui/` dan buat komponen:
    - `button.blade.php` — varian `primary`, `secondary`, `outline`, `danger`.
    - `card.blade.php` — untuk katalog venue dan lapangan.
    - `badge.blade.php` — untuk status booking dan ketersediaan slot.
    - `modal.blade.php` — komponen modal Alpine.js reusable untuk konfirmasi destruktif.
3. Buat rute sementara `/styleguide` untuk mendemokan semua komponen.
   **Acceptance Criteria:**
- [ ] Semua komponen UI tersedia dan dapat dipakai di seluruh modul.
- [ ] Komponen `modal` dapat dipanggil dengan Alpine.js dari halaman manapun.
- [ ] Layout bersifat mobile-first dan responsif.
- [ ] Halaman `/styleguide` menampilkan semua elemen UI.
---

### Task 1.6: Navigasi, Dashboard User, & Test Refactoring
- **ID**: `feature/06-auth-ui-refactor`
- **Assignee**: **Kamu**
- **Story Points**: `3` — Modifikasi navbar kondisional per role + update view dashboard + refactor dua file test.
- **Dependencies**: `feature/05-design-system`
  **Langkah Teknis:**
1. Modifikasi `layouts/navigation.blade.php`: tampilkan menu "Panel Admin" untuk `admin` dan "Riwayat Booking" untuk `user`.
2. Update `dashboard/index.blade.php`: tampilkan ringkasan aktivitas booking user.
3. Refaktor `tests/Feature/Auth/RegistrationTest.php` agar memvalidasi kolom `role`, `phone`.
   **Acceptance Criteria:**
- [ ] Navbar menampilkan link yang sesuai berdasarkan role.
- [ ] Unit test autentikasi mencakup validasi kolom `role`.

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

### **Task 2.5: Implementasi Standarisasi UI/UX Admin & Navigasi**
- **ID**: `feature/2.5-admin-ui-enhancement`
- **Deskripsi**: Menyempurnakan tampilan halaman CRUD Kategori Olahraga dan Lapangan agar sesuai dengan Design Guideline, termasuk penerapan tabel responsif, modal konfirmasi penghapusan, empty state, validasi form, serta penyempurnaan navigasi pada Navbar.
- **Assignee**: Anggota C (Frontend) atau Anggota B (Fullstack)
- **Dependencies**: `feature/08-crud-categories`, `feature/10-crud-fields`

**Langkah Teknis:**
1. **Layout & Navigasi (Navbar, Sidebar, Breadcrumb)**:
    - **Navbar**: Implementasikan navigasi atas (Navbar) yang bersifat sticky dengan utilitas `backdrop-blur-sm bg-white/80` saat halaman di-scroll ke bawah. Pastikan tinggi navbar tetap (h-16). Untuk pengguna layar kecil (mobile), buat menu hamburger fungsional menggunakan Alpine.js (`x-show` beserta slide transition). Berikan indikator visual pada menu yang sedang aktif menggunakan teks `text-primary-600 font-semibold` dan garis bawah `border-b-2 border-primary-600`.
    - **Sidebar Admin**: Pastikan menggunakan warna latar `bg-gray-900` dengan teks `text-gray-300`, dan menu aktif ditandai dengan `bg-gray-800 text-white rounded-lg`.
    - **Breadcrumb**: Implementasikan di bagian atas halaman detail dan manajemen admin sebagai panduan lokasi halaman bagi pengguna.
2. **Tabel Responsif & Ikon**: Buat tabel daftar kategori dan lapangan menggunakan wrapper `overflow-x-auto` dan `min-w-full` untuk tampilan seluler. Gunakan komponen tombol ukuran sm (`px-3 py-1.5 text-xs`) di dalam baris tabel untuk aksi. Tambahkan Heroicons berjenis outline (ukuran `size-4` di dalam tombol), seperti `PencilSquareIcon` untuk Edit dan `TrashIcon` untuk Hapus.
3. **Modal Konfirmasi (Aksesibilitas)**: Buat komponen Modal Konfirmasi menggunakan Alpine.js (dengan durasi transisi masuk 300ms). Modal ini wajib dipanggil dan ditampilkan pada setiap aksi destruktif (seperti menghapus kategori atau lapangan) sebelum data benar-benar dihapus. Tombol hapus di dalam modal harus menggunakan `variant-danger`.
4. **Form & Pesan Kesalahan**: Terapkan error state visual yang jelas pada form input apabila validasi Laravel gagal, dan pastikan setiap input memiliki `<label>` yang terhubung dengan baik via `for` / `id`.
5. **Empty State & Flash Message**: Buat tampilan Empty State yang informatif apabila data kategori atau lapangan masih kosong di tabel. Sempurnakan tampilan Flash Message (Alert) menggunakan warna semantic (misalnya token warna success dengan hex `#16a34a` atau kelas `green-600`) untuk operasi CRUD yang berhasil.

**Acceptance Criteria:**
- [ ] Navigasi Navbar terimplementasi dengan baik, merespons scroll (sticky), memiliki menu hamburger interaktif pada ukuran layar mobile, dan menyoroti menu halaman yang sedang aktif.
- [ ] Tampilan tabel dapat digeser (scroll) secara horizontal pada layar mobile tanpa merusak layout halaman.
- [ ] Menekan tombol "Hapus" pada data kategori atau lapangan tidak langsung menghapus data, melainkan memunculkan Modal Konfirmasi terlebih dahulu.
- [ ] Pesan error dan flash message sukses muncul dengan warna dan desain yang sesuai guideline.
- [ ] Halaman menampilkan Empty State (bukan layar kosong atau error) jika database kategori/lapangan tidak memiliki isi.
- [ ] Sidebar dan Breadcrumb berfungsi sebagai indikator navigasi yang jelas.

---

### **Task 2.6: Setup Database Fasilitas & Venue (Master Data)**
- **ID**: `feature/2.6-db-facilities-venues`
- **Deskripsi**: Membuat migrasi, model, dan seeder untuk tabel facilities, venues, serta tabel pivot venue_sport_categories dan venue_facilities.
- **Assignee**: Orlando Sugian

**Langkah Teknis:**
1. Buat migration untuk facilities (id, name, icon).
2. Buat migration untuk venues (id, name, slug, address, city, province, latitude, longitude, rating_avg, review_count, refund_policy, reschedule_policy, logo, rating_avg, review_count).
3. Buat migration untuk tabel pivot venue_sport_categories (venue_id, sports_category_id).
4. Buat migration untuk tabel pivot venue_facilities (venue_id, facility_id).
5. Buat Model Facility dan Venue.
6. Definisikan relasi belongsToMany di Model Venue untuk menghubungkannya dengan Facility dan SportsCategory.
7. Buat VenueSeeder beserta data fasilitas penunjangnya.

**Acceptance Criteria:**
- [ ] Keempat tabel berhasil dibuat di database dengan tipe data dan constraint Foreign Key yang tepat.
- [ ] Relasi Eloquent belongsToMany dapat memanggil fasilitas dan kategori olahraga dari sebuah Venue tanpa error.
- [ ] Seeder berjalan sukses dan mengisi data awal.

---

### **Task 2.7: Setup Database Lapangan (Fields, Images, Hours, Pricing)**
- **ID**: `feature/2.7-db-fields-module`
- **Deskripsi**: Membuat migrasi, model, dan seeder untuk tabel fields, field_images, field_operating_hours, dan field_pricing.
- **Assignee**: Ndzul (Anggota Tim)
- **Dependencies**: `feature/2.6-db-facilities-venues` (Harus menunggu selesai membuat Venue).

**Langkah Teknis:**
1. Buat migration untuk fields (pastikan ada venue_id dan sports_category_id).
2. Buat migration untuk field_images (tambahkan logic/trigger atau Observer Eloquent untuk handle is_primary).
3. Buat migration untuk field_operating_hours (0 = Minggu hingga 6 = Sabtu).
4. Buat migration untuk field_pricing (berisi ENUM weekday, weekend, holiday).
5. Definisikan relasi Eloquent di Model Field (belongsTo Venue, hasMany Images, Hours, dan Pricing).
6. Buat FieldSeeder yang mengaitkan lapangan ke Venue pertama di database.

**Acceptance Criteria:**
- [ ] Keempat tabel berhasil di-migrate tanpa masalah Foreign Key.
- [ ] Model Field dapat memanggil semua data relasinya dengan sukses.

---

### **Task 2.8: CRUD Lapangan & Galeri Foto**
- **ID**: `feature/2.8-crud-fields-images`
- **Deskripsi**: Membangun antarmuka untuk Admin mengelola data utama lapangan dan mengunggah galeri foto lapangan.
- **Assignee**: Ndzul (Anggota Tim)

**Langkah Teknis:**
1. Buat AdminFieldController (metode index, create, store, edit, update, destroy).
2. Modifikasi form create/edit agar Admin wajib memilih venue_id tempat lapangan ini berada.
3. Buat fitur upload multiple foto untuk field_images menggunakan Laravel Storage (jangan lupa jalankan php artisan storage:link).
4. Berikan tombol antarmuka untuk mengatur foto mana yang menjadi is_primary = 1.

**Acceptance Criteria:**
- [ ] Admin dapat menambah, mengedit, dan menghapus Lapangan.
- [ ] Admin dapat mengunggah banyak foto sekaligus untuk satu lapangan.
- [ ] Hanya ada satu foto yang berstatus primary per lapangan.
- [ ] Menghapus lapangan akan otomatis menghapus file fotonya dari storage lokal.

---

### **Task 2.9: Manajemen Jam Operasional & Harga Lapangan**
- **ID**: `feature/2.9-crud-fields-hours-pricing`
- **Deskripsi**: Membangun form antarmuka dinamis untuk menetapkan jam buka-tutup (7 hari) dan menetapkan 3 skema harga (Weekday, Weekend, Holiday) per lapangan.
- **Assignee**: Ndzul (Anggota Tim)
- **Dependencies**: `feature/2.8-crud-fields-images`

**Langkah Teknis:**
1. Buat view manajemen khusus (atau tab terpisah di halaman detail lapangan) untuk Hours dan Pricing.
2. Pada jam operasional, buat form looping untuk 7 hari (Minggu s/d Sabtu) yang memungkinkan input open_time, close_time, dan toggle is_open.
3. Pada harga, sediakan 3 input tetap (Weekday, Weekend, Holiday) yang akan disimpan ke tabel field_pricing.
4. Bungkus proses insert/update menggunakan DB::transaction() agar data tersimpan secara atomik.

**Acceptance Criteria:**
- [ ] Admin dapat mengatur jam buka dan tutup spesifik untuk tiap hari dalam seminggu.
- [ ] Admin dapat mengisi 3 jenis harga, dan harga tersebut tersimpan dengan benar di tabel field_pricing.
- [ ] Terdapat validasi backend yang memastikan close_time harus lebih besar dari open_time.

---

## Epic 3: Sistem Booking (Core Logic)

### **Task 3.1: Setup Database Transaksi, Users (Revisi), & Holidays**
- **ID**: `feature/3.1-db-core-transactions`
- **Deskripsi**: Melakukan revisi tabel users, serta membuat migrasi untuk public_holidays, bookings, booking_slots, payments, dan reviews.
- **Assignee**: Orlandos
- **Dependencies**: `feature/09-db-fields-module`

**Langkah Teknis:**
1. Revisi migration users sesuai skema terbaru (tambah phone, avatar).
2. Buat migration `public_holidays`.
3. Buat migration `bookings` dan `booking_slots`. Pastikan menambahkan Constraint Unique Key di `booking_slots` untuk mencegah double-booking.
4. Buat migration `payments` dan `reviews`.
5. Di migration `reviews`, tambahkan `DB::unprepared()` untuk menjalankan eksekusi Trigger MySQL pengubah `rating_avg` di tabel `venues`. (Alternatif: Gunakan Eloquent Observer pada Model Review).
6. Definisikan semua relasi Model (User, Booking, BookingSlot, Payment, Review).

**Acceptance Criteria:**
- [ ] Semua tabel terbentuk sempurna tanpa error Foreign Key.
- [ ] Relasi antar-Model berfungsi dengan baik.
---

### **Task 3.2: API Ketersediaan Slot**
- **ID**: `feature/3.2-api-availability-pricing`
- **Deskripsi**: Membuat servis backend untuk mengecek jam kosong dan menghitung harga otomatis (Weekday/Weekend/Holiday).
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Buat rute API internal (misal: `/api/fields/{field}/slots`).
2. Buat fungsi logika di Controller/Service yang:
    - Mengecek hari dari tanggal yang dipilih (`day_of_week`).
    - Mengecek apakah tanggal tersebut ada di tabel `public_holidays`.
    - Mengambil `open_time` dan `close_time` dari `field_operating_hours`.
    - Mengecek tabel `booking_slots` pada tanggal tersebut.
3. Kembalikan data JSON berupa daftar slot jam, status `available` (true/false), dan harga spesifik (`price_per_slot`) pada hari tersebut.

**Acceptance Criteria:**
- [ ] API mengembalikan status `false` pada jam yang sudah dipesan (berada di tabel `booking_slots`).
- [ ] Harga yang dikembalikan otomatis berubah menjadi harga Holiday jika tanggal cocok dengan tabel `public_holidays`.

---

### **Task 3.3: Service & Validasi Booking**
- **ID**: `feature/3.3-booking-checkout`
- **Deskripsi**: Membangun logika pembuatan pesanan yang aman dari Race Condition.
- **Assignee**: Indra Suryadilaga

**Langkah Teknis:**
1. Buat `app/Services/BookingService.php`.
2. Buat fungsi `createBooking()`.
3. Bungkus eksekusi penyimpanan ke tabel `bookings` dan `booking_slots` dalam `DB::transaction()`.
4. Implementasikan Pessimistic Locking (menggunakan `lockForUpdate()`) saat memverifikasi ulang apakah slot yang dipilih masih kosong.
5. Set `expires_at` pesanan (misal 30 menit dari waktu pembuatan).

**Acceptance Criteria:**
- [ ] Pesanan berhasil masuk ke database beserta detail slotnya.
- [ ] Menekan tombol "Booking" dua kali di detik yang sama (atau oleh dua user berbeda) tidak menyebabkan bentrok data berkat validasi `uq_slot` dan Locking.

---

### **Task 3.4: UI Booking & Interaksi Pengguna**
- **ID**: `feature/3.4-ui-booking`
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

### **Task 4.1: Buat Migration dan relasi untuk payments**
- **ID**: `feature/4.1-db-payments`
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

### **Task 4.2: Simulasi Sistem Pembayaran**
- **ID**: `feature/4.2-payment-system`
- **Deskripsi**: Membuat antarmuka pengguna untuk melakukan simulasi pembayaran pesanan dan memperbarui status transaksinya (Peleburan Task 4.2 & 4.5).
- **Assignee**: Ndzul
- **Dependencies**: `feature/4.1-db-payments`, `feature/3.3-booking-checkout`

**Langkah Teknis:**
1. Buat `PaymentController` dengan metode `show` dan `update`.
2. Buat view simulasi di `resources/views/dashboard/payments/show.blade.php`.
3. Sediakan tombol "Bayar Sekarang" (berhasil) dan "Batalkan" (gagal/batal).
4. Logika update: Buat entri baru di tabel `payments`. Jika berhasil, perbarui status di tabel `bookings` menjadi `paid` (atau `cancelled` jika dibatalkan).
5. Redirect pengguna kembali ke halaman riwayat transaksi dengan flash message.

**Acceptance Criteria:**
- [ ] Menekan tombol "Bayar Sekarang" berhasil membuat entri di tabel `payments` dan mengubah status pesanan menjadi `paid`.
- [ ] Pengguna mendapatkan feedback visual (pesan sukses/gagal) setelah melakukan aksi pembayaran.

---

### **Task 4.3: Job Otomatisasi: Kedaluwarsa**
- **ID**: `feature/4.3-job-expiration`
- **Deskripsi**: Membuat Command/Job terjadwal untuk membatalkan pesanan yang melewati batas waktu pembayaran secara otomatis.
- **Assignee**: Indra Suryadilaga
- **Dependencies**: `feature/3.3-booking-checkout`

**Langkah Teknis:**
1. Buat Job via `php artisan make:job ExpireUnpaidBookings`.
2. Tulis query di dalam `handle()`: Cari semua tabel `bookings` yang berstatus `pending` di mana `expires_at < now()`.
3. Ubah status pesanan yang ditemukan menjadi `expired`.
4. **Krusial**: Bebaskan kembali slot waktu tersebut dengan menghapus baris terkait di tabel `booking_slots` agar pengguna lain bisa memesannya lagi.
5. Daftarkan tugas ini di `routes/console.php` agar berjalan otomatis setiap menit (`->everyMinute()`).

**Acceptance Criteria:**
- [ ] Pesanan `pending` yang melewati batas waktu otomatis berubah menjadi `expired` saat scheduler dijalankan.
- [ ] Data slot dari pesanan yang kedaluwarsa berhasil dihapus dari tabel `booking_slots` (slot kembali tersedia).
---

### **Task 4.4: Job Otomatisasi: Selesai**
- **ID**: `feature/4.4-job-completion`
- **Deskripsi**: Membuat job terjadwal untuk mengubah status booking yang telah selesai.
- **Assignee**: Anggota A (Backend)

**Langkah Teknis:**
1. Buat job `php artisan make:job CompleteFinishedBookings`.
2. Logika di `handle()`: Cari booking `paid` yang waktu bermainnya sudah lewat, lalu ubah statusnya menjadi `completed`.
3. Daftarkan job di `app/Console/Kernel.php` untuk berjalan periodik (misal: `hourly()`).

**Acceptance Criteria:**
- [ ] Booking `paid` yang sudah lewat jamnya otomatis berubah menjadi `completed`.
- [ ] Job tidak mengubah status booking selain `paid`.

---

### **Task 4.6: Sistem Ulasan (Reviews)**
- **ID**: `feature/4.6-reviews-system`
- **Deskripsi**: Membangun form bagi user untuk memberi nilai pada tempat yang telah selesai dimainkan.
- **Assignee**: Indra Suryadilaga
- **Dependencies**: `feature/4.4-job-completion`

**Langkah Teknis:**
1. Pada halaman "Riwayat Booking" User, munculkan tombol "Beri Ulasan" khusus untuk pesanan berstatus completed.
2. Buat form ulasan (rating 1-5 dan teks komentar).
3. Simpan data ke tabel reviews. Pastikan validasi uq_rev_booking (1 booking hanya boleh 1 kali review).

**Acceptance Criteria:**
- [ ] User tidak bisa me-review pesanan yang belum selesai (completed).
- [ ] Menyimpan review otomatis memperbarui cache `rating_avg` dan `review_count` pada Venue (melalui Trigger MySQL atau Observer).
