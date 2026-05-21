# Design Guideline

# Sistem Booking Lapangan Olahraga Berbasis Web

> **Stack:** Laravel 13 · Tailwind CSS v4 · Alpine.js · Blade
> **Pendekatan:** Mobile-first · Utility-first · Component-driven

---

## 1. Identitas Visual & Prinsip Desain

### 1.1 Karakter Brand

Sistem ini bukan sekadar aplikasi utilitas — ini adalah "arena digital". Desain harus mencerminkan:

| Nilai          | Implementasi Visual                                             |
| -------------- | --------------------------------------------------------------- |
| **Energik**    | Warna primer yang kuat, elemen bergerak, ikon aktif             |
| **Terpercaya** | Tipografi bersih, spacing konsisten, status informatif          |
| **Efisien**    | Layout tanpa distraksi, CTA jelas, alur minimal klik            |
| **Modern**     | Dark section pada hero, kartu dengan border halus, shadow tipis |

### 1.2 Prinsip Utama

1. **Clarity over decoration** — Setiap elemen harus punya fungsi. Hindari ornamen tanpa tujuan.
2. **Status harus selalu terlihat** — Setiap slot dan transaksi wajib memiliki penanda visual status yang jelas.
3. **Mobile-first** — Desain dimulai dari lebar 375px, baru naik ke desktop.
4. **Konsistensi komponen** — Satu jenis tombol, satu jenis card, dipakai di seluruh halaman.

---

## 2. Palet Warna

### 2.1 Warna Utama (Primary Palette)

Tema warna menggunakan **biru-hijau sporty** — mencerminkan energi lapangan dan kepercayaan sistem.

```css
/* Tailwind CSS v4 — definisikan di CSS root */
@theme {
  --color-primary-50: #eff6ff;
  --color-primary-100: #dbeafe;
  --color-primary-500: #3b82f6; /* Biru utama — CTA, link aktif */
  --color-primary-600: #2563eb; /* Hover state tombol primer */
  --color-primary-700: #1d4ed8; /* Pressed / focus ring */
  --color-primary-900: #1e3a8a; /* Teks di atas background terang */

  --color-accent-400: #34d399; /* Hijau — slot tersedia, status paid */
  --color-accent-500: #10b981; /* Hijau gelap — hover state */
  --color-accent-600: #059669;
}
```

### 2.2 Warna Status (Semantic Colors)

Warna ini dipakai **eksklusif** untuk status — jangan gunakan untuk dekorasi.

| Token     | Hex       | Tailwind Class | Penggunaan                                  |
| --------- | --------- | -------------- | ------------------------------------------- |
| `success` | `#16a34a` | `green-600`    | Slot tersedia, status `paid`, flash sukses  |
| `warning` | `#d97706` | `amber-600`    | Status `pending`, belum dibayar             |
| `danger`  | `#dc2626` | `red-600`      | Slot terpesan, aksi hapus/batalkan          |
| `info`    | `#0284c7` | `sky-600`      | Status `completed`, informasi netral        |
| `muted`   | `#9ca3af` | `gray-400`     | Slot lampau, tombol disabled, teks sekunder |
| `expired` | `#6b7280` | `gray-500`     | Status `expired`, tidak aktif               |

### 2.3 Warna Netral (Neutral Scale)

```
gray-50  → #f9fafb  — Background halaman utama
gray-100 → #f3f4f6  — Background card, input field
gray-200 → #e5e7eb  — Border default, divider
gray-500 → #6b7280  — Teks sekunder / placeholder
gray-700 → #374151  — Teks body utama
gray-900 → #111827  — Heading, teks paling gelap
```

### 2.4 Warna Slot Kalender

| State             | Background | Border      | Teks        | Tailwind                     |
| ----------------- | ---------- | ----------- | ----------- | ---------------------------- |
| Tersedia          | `green-50` | `green-400` | `green-700` | Klik aktif                   |
| Dipilih           | `blue-500` | `blue-600`  | `white`     | Toggle aktif                 |
| Terpesan          | `red-50`   | `red-300`   | `red-400`   | Disabled, cursor-not-allowed |
| Lewat             | `gray-100` | `gray-200`  | `gray-400`  | Disabled                     |
| Operasional tutup | `gray-50`  | `gray-100`  | `gray-300`  | Tidak ditampilkan            |

---

## 3. Tipografi

### 3.1 Font Family

```css
@theme {
  --font-sans: "Plus Jakarta Sans", "Inter", ui-sans-serif, system-ui;
}
```

> **Rekomendasi:** **Plus Jakarta Sans** (Google Fonts) — terasa modern, sporty, mudah dibaca. Alternatif: **Inter** atau **DM Sans**.

Import di `resources/css/app.css`:

```css
@import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap");
```

### 3.2 Skala Tipografi

| Tag     | Size            | Weight | Tailwind                  | Penggunaan                     |
| ------- | --------------- | ------ | ------------------------- | ------------------------------ |
| `h1`    | 36px / 2.25rem  | 800    | `text-4xl font-extrabold` | Hero headline                  |
| `h2`    | 28px / 1.75rem  | 700    | `text-3xl font-bold`      | Judul section                  |
| `h3`    | 22px / 1.375rem | 600    | `text-2xl font-semibold`  | Judul card, sub-section        |
| `h4`    | 18px / 1.125rem | 600    | `text-lg font-semibold`   | Label grup, heading minor      |
| `body`  | 16px / 1rem     | 400    | `text-base font-normal`   | Teks paragraf utama            |
| `small` | 14px / 0.875rem | 400    | `text-sm`                 | Meta info, caption, label form |
| `xs`    | 12px / 0.75rem  | 500    | `text-xs font-medium`     | Badge, microcopy, timestamp    |

### 3.3 Aturan Penulisan

- **Line height:** `leading-relaxed` (1.625) untuk paragraf; `leading-tight` untuk heading.
- **Warna teks:** `text-gray-900` untuk heading; `text-gray-700` untuk body; `text-gray-500` untuk sekunder.
- **Maks lebar teks paragraf:** `max-w-prose` (65ch) — agar tidak terlalu lebar dan susah dibaca.
- **Jangan** gunakan lebih dari 2 ukuran font dalam satu komponen kecil.

---

## 4. Spacing & Layout

### 4.1 Grid System

```
Maks lebar konten: max-w-7xl (1280px)
Padding horizontal: px-4 (mobile) → px-6 (tablet) → px-8 (desktop)
Padding halaman: py-8 (mobile) → py-12 (desktop)
```

### 4.2 Spacing Scale yang Digunakan

| Token      | Nilai | Penggunaan Khas                |
| ---------- | ----- | ------------------------------ |
| `space-1`  | 4px   | Gap antar ikon & teks          |
| `space-2`  | 8px   | Padding badge, margin label    |
| `space-3`  | 12px  | Gap dalam card kecil           |
| `space-4`  | 16px  | Padding internal komponen      |
| `space-6`  | 24px  | Margin antar elemen dalam card |
| `space-8`  | 32px  | Gap antar card dalam grid      |
| `space-12` | 48px  | Margin antar section halaman   |
| `space-16` | 64px  | Padding section besar          |

### 4.3 Layout Halaman Publik

```
[Navbar — sticky, h-16]
  ↕ py-0
[Main Content — max-w-7xl mx-auto px-4]
  ↕ py-12
[Footer — bg-gray-900]
```

### 4.4 Layout Admin (Sidebar)

```
[Sidebar — fixed, w-64, bg-gray-900]   [Main Area — ml-64]
                                          [Topbar — h-16, border-b]
                                          [Content — p-6]
```

---

## 5. Komponen UI

### 5.1 Tombol (Buttons)

**Aturan wajib:**

- Tombol aksi utama (1 per section) → `variant-primary`
- Aksi sekunder/netral → `variant-outline`
- Aksi destruktif → `variant-danger`
- Selalu gunakan `transition` dan `focus:ring` untuk aksesibilitas

```html
<!-- PRIMARY — Booking, Bayar, Simpan -->
<button
  class="inline-flex items-center gap-2 rounded-lg bg-primary-600
               px-5 py-2.5 text-sm font-semibold text-white
               hover:bg-primary-700 focus:outline-none
               focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
               transition-colors duration-150 disabled:opacity-50
               disabled:cursor-not-allowed"
>
  Booking Sekarang
</button>

<!-- SECONDARY — Kembali, Lihat Detail -->
<button
  class="inline-flex items-center gap-2 rounded-lg border border-gray-300
               px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white
               hover:bg-gray-50 focus:ring-2 focus:ring-gray-300
               transition-colors duration-150"
>
  Lihat Detail
</button>

<!-- DANGER — Hapus, Batalkan Pesanan -->
<button
  class="inline-flex items-center gap-2 rounded-lg border border-red-300
               px-5 py-2.5 text-sm font-semibold text-red-600 bg-white
               hover:bg-red-50 focus:ring-2 focus:ring-red-300
               transition-colors duration-150"
>
  Batalkan Pesanan
</button>

<!-- GHOST — Aksi tersier, navigasi halus -->
<button
  class="inline-flex items-center gap-1.5 rounded-lg px-4 py-2
               text-sm font-medium text-gray-500 hover:text-gray-900
               hover:bg-gray-100 transition-colors duration-150"
>
  Selengkapnya →
</button>
```

**Ukuran tombol:**
| Ukuran | Class | Penggunaan |
|---|---|---|
| `sm` | `px-3 py-1.5 text-xs` | Aksi dalam tabel/baris |
| `md` | `px-5 py-2.5 text-sm` | Default — form, card |
| `lg` | `px-6 py-3 text-base` | CTA hero, halaman kosong |

---

### 5.2 Card Lapangan

```html
<div
  class="group rounded-2xl border border-gray-200 bg-white
            overflow-hidden shadow-sm hover:shadow-md
            transition-shadow duration-200"
>
  <!-- Foto -->
  <div class="relative aspect-video overflow-hidden">
    <img
      src="..."
      alt="..."
      class="w-full h-full object-cover
         group-hover:scale-105 transition-transform duration-300"
    />

    <!-- Badge Olahraga -->
    <span
      class="absolute top-3 left-3 rounded-full bg-white/90 backdrop-blur-sm
                 px-2.5 py-1 text-xs font-semibold text-primary-700"
    >
      Futsal
    </span>
  </div>

  <!-- Info -->
  <div class="p-5">
    <h3 class="text-base font-semibold text-gray-900 truncate">Lapangan A</h3>
    <p class="mt-1 text-sm text-gray-500">Jl. Merdeka No. 10</p>

    <div class="mt-4 flex items-center justify-between">
      <p class="text-sm font-bold text-primary-600">
        Mulai Rp 80.000<span class="font-normal text-gray-400"> / slot</span>
      </p>
      <a
        href="#"
        class="rounded-lg bg-primary-600 px-3 py-1.5
                         text-xs font-semibold text-white
                         hover:bg-primary-700 transition-colors"
      >
        Cek Jadwal
      </a>
    </div>
  </div>
</div>
```

---

### 5.3 Badge Status Booking

```html
<!-- Sesuaikan class berdasarkan status -->
<!-- pending -->
<span
  class="inline-flex items-center gap-1.5 rounded-full bg-amber-50
             px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1
             ring-amber-200"
>
  <span class="size-1.5 rounded-full bg-amber-500"></span>
  Menunggu Pembayaran
</span>

<!-- paid -->
<span class="... bg-blue-50 text-blue-700 ring-blue-200">
  <span class="... bg-blue-500"></span> Lunas
</span>

<!-- completed -->
<span class="... bg-green-50 text-green-700 ring-green-200">
  <span class="... bg-green-500"></span> Selesai
</span>

<!-- cancelled -->
<span class="... bg-red-50 text-red-700 ring-red-200">
  <span class="... bg-red-400"></span> Dibatalkan
</span>

<!-- expired -->
<span class="... bg-gray-100 text-gray-500 ring-gray-200">
  <span class="... bg-gray-400"></span> Kedaluwarsa
</span>
```

---

### 5.4 Slot Kalender

```html
<!-- Satu slot dalam grid kalender -->

<!-- Tersedia -->
<button
  class="rounded-lg border-2 border-green-300 bg-green-50 px-3 py-2
               text-xs font-semibold text-green-700 text-center
               hover:bg-green-100 hover:border-green-400
               transition-all duration-150 cursor-pointer"
>
  08:00 – 09:00
</button>

<!-- Dipilih (selected) -->
<button
  class="rounded-lg border-2 border-primary-600 bg-primary-600 px-3 py-2
               text-xs font-semibold text-white text-center
               ring-2 ring-primary-300 ring-offset-1
               transition-all duration-150"
>
  ✓ 09:00 – 10:00
</button>

<!-- Terpesan -->
<button
  disabled
  class="rounded-lg border-2 border-red-200 bg-red-50 px-3 py-2
               text-xs font-semibold text-red-400 text-center
               cursor-not-allowed opacity-70"
>
  Penuh
</button>

<!-- Sudah lewat -->
<button
  disabled
  class="rounded-lg border-2 border-gray-100 bg-gray-50 px-3 py-2
               text-xs text-gray-300 text-center cursor-not-allowed"
>
  07:00 – 08:00
</button>
```

**Grid layout kalender:**

```html
<div class="grid grid-cols-3 gap-2 sm:grid-cols-4 lg:grid-cols-6">
  <!-- slot items -->
</div>
```

---

### 5.5 Form Input

```html
<!-- Label + Input standar -->
<div class="space-y-1.5">
  <label class="block text-sm font-medium text-gray-700">
    Alamat Email Aktif
    <span class="text-red-500">*</span>
  </label>
  <input
    type="email"
    class="block w-full rounded-lg border border-gray-300 bg-white
                px-3.5 py-2.5 text-sm text-gray-900
                placeholder:text-gray-400
                focus:border-primary-500 focus:ring-2 focus:ring-primary-200
                transition duration-150"
    placeholder="contoh@email.com"
  />
  <!-- Error state: ganti border-gray-300 dengan border-red-400 -->
  <!-- Error message -->
  <p class="text-xs text-red-500">Format email tidak valid.</p>
</div>

<!-- Select -->
<select
  class="block w-full rounded-lg border border-gray-300 bg-white
               px-3.5 py-2.5 text-sm text-gray-900
               focus:border-primary-500 focus:ring-2 focus:ring-primary-200
               transition duration-150"
>
  <option value="">Pilih Jenis Olahraga</option>
</select>
```

---

### 5.6 Alert / Flash Message

```html
<!-- Success -->
<div
  class="flex items-start gap-3 rounded-xl bg-green-50 border border-green-200
            p-4 text-sm text-green-800"
>
  <!-- Heroicon: check-circle -->
  <svg class="size-5 shrink-0 text-green-500 mt-0.5" ...></svg>
  <p>
    <span class="font-semibold">Berhasil!</span> Booking kamu telah
    dikonfirmasi.
  </p>
</div>

<!-- Error -->
<div class="... bg-red-50 border-red-200 text-red-800">...</div>

<!-- Warning -->
<div class="... bg-amber-50 border-amber-200 text-amber-800">...</div>
```

---

### 5.7 Empty State

```html
<div class="flex flex-col items-center justify-center py-16 text-center">
  <!-- Ilustrasi SVG atau Ikon besar -->
  <div class="mb-4 rounded-full bg-gray-100 p-5">
    <svg class="size-10 text-gray-400" ...></svg>
  </div>
  <h3 class="text-base font-semibold text-gray-900">Belum ada jadwal main</h3>
  <p class="mt-1 text-sm text-gray-500 max-w-xs">
    Jangan biarkan keringatmu mengering. Ayo temukan lapangan pertamamu!
  </p>
  <a
    href="/catalog"
    class="mt-5 inline-flex items-center gap-2 rounded-lg bg-primary-600
            px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-700
            transition-colors"
  >
    Cari Lapangan Sekarang
  </a>
</div>
```

---

### 5.8 Stat Card (Admin Dashboard)

```html
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
  <div class="flex items-center justify-between">
    <p class="text-sm font-medium text-gray-500">Total Booking Hari Ini</p>
    <!-- Ikon dalam kotak berwarna -->
    <div class="rounded-xl bg-primary-50 p-2.5">
      <svg class="size-5 text-primary-600" ...></svg>
    </div>
  </div>
  <p class="mt-3 text-3xl font-bold text-gray-900">24</p>
  <p class="mt-1 text-xs text-green-600 font-medium">↑ 12% dari kemarin</p>
</div>
```

---

### 5.9 Modal Konfirmasi

```html
<!-- Trigger via Alpine.js x-show -->
<div
  x-show="isOpen"
  class="fixed inset-0 z-50 flex items-center justify-center p-4"
  x-transition
>
  <!-- Overlay -->
  <div
    class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
    @click="isOpen = false"
  ></div>

  <!-- Panel -->
  <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
    <h3 class="text-base font-semibold text-gray-900">Batalkan Pesanan?</h3>
    <p class="mt-2 text-sm text-gray-500">
      Tindakan ini tidak dapat dibatalkan. Slot yang sudah kamu pesan akan
      dikembalikan ke publik.
    </p>
    <div class="mt-6 flex justify-end gap-3">
      <button
        @click="isOpen = false"
        class="rounded-lg border border-gray-300 px-4 py-2
                     text-sm font-semibold text-gray-700 hover:bg-gray-50"
      >
        Tidak, Kembali
      </button>
      <button
        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold
                     text-white hover:bg-red-700 transition-colors"
      >
        Ya, Batalkan
      </button>
    </div>
  </div>
</div>
```

---

## 6. Navigasi

### 6.1 Navbar Publik

```
[Logo]  [Catalog]  [Cara Kerja]          [Masuk]  [Daftar — filled button]
```

- **Sticky** dengan `backdrop-blur-sm bg-white/80` saat di-scroll.
- Tinggi tetap: `h-16`.
- Di mobile: hamburger menu dengan Alpine.js (`x-show` + slide transition).
- Indikator halaman aktif: `text-primary-600 font-semibold` + garis bawah `border-b-2 border-primary-600`.

### 6.2 Sidebar Admin

```
[Logo + Nama Sistem]
─────────────────────
📊  Dashboard
🏟️  Lapangan
🏅  Kategori Olahraga
📋  Booking Global
─────────────────────
[Avatar Admin]
[Logout]
```

- Background: `bg-gray-900` teks `text-gray-300`
- Item aktif: `bg-gray-800 text-white rounded-lg`
- Hover: `hover:bg-gray-800 hover:text-white transition-colors`

### 6.3 Breadcrumb (Halaman Admin & Detail)

```html
<nav class="flex items-center gap-2 text-sm text-gray-500">
  <a href="/admin" class="hover:text-gray-700">Dashboard</a>
  <span>/</span>
  <a href="/admin/fields" class="hover:text-gray-700">Lapangan</a>
  <span>/</span>
  <span class="font-medium text-gray-900">Tambah Lapangan</span>
</nav>
```

---

## 7. Responsivitas

### Breakpoint Utama (Tailwind Default)

| Prefix   | Min-width | Target Perangkat                |
| -------- | --------- | ------------------------------- |
| _(none)_ | 0px       | Mobile portrait (375px)         |
| `sm:`    | 640px     | Mobile landscape / tablet kecil |
| `md:`    | 768px     | Tablet                          |
| `lg:`    | 1024px    | Laptop / desktop kecil          |
| `xl:`    | 1280px    | Desktop penuh                   |

### Grid Responsif Kunci

```html
<!-- Grid Katalog Lapangan -->
<div
  class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
>
  <!-- Grid Keunggulan Beranda -->
  <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
    <!-- Grid Slot Kalender -->
    <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 lg:grid-cols-6">
      <!-- Stat Cards Admin -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4"></div>
    </div>
  </div>
</div>
```

### Aturan Mobile

- Tombol di halaman konfirmasi: `w-full` di mobile, `auto` di `sm:`.
- Sidebar admin: pada mobile, sidebar disembunyikan dan diakses via hamburger icon.
- Tabel booking: gunakan `overflow-x-auto` wrapper + `min-w-full` pada tabel.
- Kalender slot: grid 3 kolom di mobile, 6 kolom di desktop.

---

## 8. Ikonografi

### Library: Heroicons (Outline style default)

```html
<!-- Install via npm jika perlu, atau pakai SVG inline -->
<!-- Contoh: ikon kalender -->
<svg
  xmlns="http://www.w3.org/2000/svg"
  fill="none"
  viewBox="0 0 24 24"
  stroke-width="1.5"
  stroke="currentColor"
  class="size-5"
>
  <path
    stroke-linecap="round"
    stroke-linejoin="round"
    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0
           012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25..."
  />
</svg>
```

### Panduan Penggunaan Ikon

| Konteks                | Ukuran               | Style              |
| ---------------------- | -------------------- | ------------------ |
| Dalam tombol           | `size-4`             | Outline            |
| Standalone navigasi    | `size-5`             | Outline            |
| Dalam stat card        | `size-5`             | Outline atau Solid |
| Hero / ilustrasi besar | `size-12` atau lebih | Solid atau custom  |
| Badge / inline teks    | `size-3.5`           | Solid              |

**Ikon kunci yang dibutuhkan:**

| Fungsi            | Heroicon                  |
| ----------------- | ------------------------- |
| Kalender          | `CalendarDaysIcon`        |
| Lokasi            | `MapPinIcon`              |
| Jam               | `ClockIcon`               |
| Ceklis / Berhasil | `CheckCircleIcon`         |
| Peringatan        | `ExclamationTriangleIcon` |
| Hapus             | `TrashIcon`               |
| Edit              | `PencilSquareIcon`        |
| User              | `UserCircleIcon`          |
| Pembayaran        | `CreditCardIcon`          |
| Olahraga / Trophy | `TrophyIcon`              |

---

## 9. Animasi & Transisi

### Aturan Umum

- **Durasi:** 150ms untuk mikro-interaksi (hover, focus); 300ms untuk transisi halaman/modal.
- **Easing:** `ease-in-out` default; `ease-out` untuk elemen masuk layar.
- Jangan animasikan lebih dari 3 hal sekaligus dalam satu komponen.

### Kelas Tailwind yang Direkomendasikan

```html
<!-- Hover card -->
hover:shadow-md transition-shadow duration-200

<!-- Hover gambar (zoom) -->
group-hover:scale-105 transition-transform duration-300

<!-- Tombol hover warna -->
hover:bg-primary-700 transition-colors duration-150

<!-- Modal masuk (Alpine.js) -->
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0 scale-95"
x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition
ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
x-transition:leave-end="opacity-0 scale-95"

<!-- Slot kalender terpilih -->
transition-all duration-150
```

---

## 10. Hero Section (Beranda)

```
Background: bg-gradient-to-br from-gray-900 via-primary-950 to-gray-900
            (atau foto lapangan dengan overlay gelap: bg-black/60)

[H1] Pesan Lapangan Olahraga Favoritmu dalam Hitungan Detik.
     → text-4xl lg:text-6xl font-extrabold text-white

[Sub-headline] Bebas ribet, tanpa antre. Cek ketersediaan ...
     → text-lg text-gray-300 max-w-xl mt-4

[CTA Group]
     → [Cari Lapangan Sekarang] primary large
     → [Lihat Cara Kerja] ghost/outline, teks putih

[Statistik kecil di bawah] — "200+ Lapangan · 10 Kota · 5000 Booking"
     → text-sm text-gray-400, dipisah dot/pipe
```

---

## 11. Footer

```
Background: bg-gray-900
Teks: text-gray-400, link hover:text-white

[Kolom 1 — Brand]
  Logo + Nama Sistem
  Deskripsi singkat 1-2 kalimat

[Kolom 2 — Navigasi]
  Beranda · Katalog · Cara Kerja

[Kolom 3 — Akun]
  Masuk · Daftar · Dashboard

[Kolom 4 — Kontak]
  Email · Instagram · WhatsApp

[Bawah — Copyright]
  border-t border-gray-800
  © 2025 NamaAplikasi. Semua hak dilindungi.
```

---

## 12. Panduan Aksesibilitas (A11y)

- Semua tombol wajib memiliki `focus:ring-2` yang terlihat.
- Semua `<img>` wajib memiliki `alt` yang deskriptif.
- Kontras warna teks minimal **4.5:1** (WCAG AA). Hindari teks putih di atas `yellow-400`.
- Form input wajib memiliki `<label>` yang terhubung via `for` / `id`.
- Tombol destruktif (hapus/batalkan) wajib memiliki konfirmasi modal.
- Slot kalender yang disabled wajib menggunakan `disabled` attribute + `aria-label`.
- Gunakan `aria-live="polite"` pada area yang berubah dinamis (misal: loading kalender slot).

---

## 13. Checklist Desain per Halaman

### Halaman Beranda

- [ ] Hero dengan gradient gelap + H1 mencolok
- [ ] 3 kolom keunggulan dengan ikon
- [ ] Grid lapangan populer (maks 4-6 card)
- [ ] CTA kedua sebelum footer ("Daftar Sekarang, Gratis!")

### Halaman Katalog

- [ ] Filter sidebar/topbar (jenis olahraga, harga)
- [ ] Grid card lapangan responsif
- [ ] Pagination atau infinite scroll
- [ ] Empty state jika tidak ada hasil filter

### Halaman Detail Lapangan

- [ ] Foto hero (aspect-video, object-cover)
- [ ] Informasi: nama, kategori, harga, jam operasional
- [ ] Kalender tanggal (date picker atau navigasi minggu)
- [ ] Grid slot interaktif dengan legenda warna
- [ ] Sticky button di mobile saat slot dipilih

### Halaman Konfirmasi Booking

- [ ] Ringkasan jelas: lapangan, tanggal, slot, total
- [ ] CTA besar "Proses ke Pembayaran"
- [ ] Tombol "Ubah Pilihan" (kembali)

### Dashboard User

- [ ] Stat cards (booking aktif, selesai)
- [ ] Tabel riwayat dengan badge status
- [ ] Empty state jika belum ada booking

### Admin Panel

- [ ] Sidebar navigasi tetap
- [ ] Stat cards 4 kolom di atas
- [ ] Tabel dengan aksi (edit, hapus, detail)
- [ ] Form dengan validasi error state yang jelas
