<x-app-layout title="Design System Styleguide">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-16">

        <div class="border-b border-neutral-200 dark:border-neutral-700 pb-5">
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">Base UI Components</h1>
            <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Kumpulan komponen UI dasar (Atoms & Molecules) untuk aplikasi.</p>
        </div>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Buttons</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <div class="flex flex-wrap gap-4 items-center">
                        <x-atoms.button type="primary">Primary</x-atoms.button>
                        <x-atoms.button type="secondary">Secondary</x-atoms.button>
                        <x-atoms.button type="danger">Destructive</x-atoms.button>
                        <x-atoms.button type="warning">Warning</x-atoms.button>
                        <x-atoms.button type="text">Text</x-atoms.button>
                    </div>
                </div>

                <div class="dark bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <div class="flex flex-wrap gap-4 items-center">
                        <x-atoms.button type="primary">Primary</x-atoms.button>
                        <x-atoms.button type="secondary">Secondary</x-atoms.button>
                        <x-atoms.button type="danger">Destructive</x-atoms.button>
                        <x-atoms.button type="warning">Warning</x-atoms.button>
                        <x-atoms.button type="text">Text</x-atoms.button>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Text Inputs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Alamat Email</label>
                        <x-atoms.input
                            type="email"
                            placeholder="nama@email.com"
                        >
                            <x-slot name="iconLeft">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </x-slot>
                        </x-atoms.input>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Kata Sandi</label>
                        <x-atoms.input
                            type="password"
                            placeholder="Masukkan kata sandi..."
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Konfirmasi Kata Sandi</label>
                        <x-atoms.input
                            type="password"
                            value="rahasiabro"
                            :error="true"
                            errorMessage="Kata sandi tidak cocok."
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Cari Lapangan</label>
                        <x-atoms.input
                            type="search"
                            placeholder="Ketik nama lapangan, kota, atau jenis olahraga..."
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Username (Dikunci)</label>
                        <x-atoms.input
                            type="text"
                            value="indra_suryadilaga"
                            disabled
                        />
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Number & Currency Inputs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Harga Sewa</label>
                        <x-atoms.input-number
                            name="tarif"
                            prefix="Rp"
                            placeholder="500.000"
                            :isCurrency="true"
                        />
                        <p class="text-xs text-neutral-500 mt-1">Gunakan format angka tanpa titik.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Durasi Booking</label>
                        <x-atoms.input-number
                            name="duration"
                            value="60"
                            suffix="Menit"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tarif Reguler</label>
                        <x-atoms.input-number
                            name="tarif"
                            prefix="Rp"
                            :isCurrency="true"
                            suffix="/ Sesi"
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Jumlah Jam Main</label>
                        <x-atoms.input-number
                            variant="stepper"
                            name="hours"
                            value="2"
                            min="1"
                            max="5"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Lama Permainan (Menit)</label>
                        <x-atoms.input-number
                            variant="stepper"
                            name="minutes"
                            value="60"
                            min="30"
                            step="30"
                        />
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Date & Time Pickers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tanggal Main</label>
                        <x-atoms.input-date
                            name="booking_date"
                            min="{{ date('Y-m-d') }}"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tanggal (Error State)</label>
                        <x-atoms.input-date
                            name="booking_date_error"
                            :error="true"
                            errorMessage="Tanggal tidak boleh di masa lalu."
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    @php
                        // Simulasi Data Jadwal dari Backend
                        $slots = [
                            ['value' => '18:00', 'label' => '18:00', 'disabled' => true],
                            ['value' => '19:00', 'label' => '19:00', 'price' => '150k'],
                            ['value' => '20:00', 'label' => '20:00', 'price' => '150k'],
                            ['value' => '21:00', 'label' => '21:00', 'price' => '175k'],
                            ['value' => '22:00', 'label' => '22:00', 'disabled' => true],
                            ['value' => '23:00', 'label' => '23:00', 'price' => '120k'],
                        ];
                    @endphp

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Pilih Jam Waktu (Single Select untuk User)</label>
                        <x-atoms.select-slot
                            name="booking_time"
                            :options="$slots"
                        />
                        <p class="text-xs text-neutral-500 mt-2">Klik slot yang tersedia. Klik lagi untuk membatalkan.</p>
                    </div>

                    <div class="pt-4 border-t border-neutral-100 dark:border-neutral-700">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Jam Operasional (Multi Select untuk Admin)</label>
                        <x-atoms.select-slot
                            name="operational_hours"
                            :options="$slots"
                            :multiple="true"
                            :selected="['19:00', '20:00']"
                        />
                        <p class="text-xs text-neutral-500 mt-2">Bisa pilih lebih dari satu waktu.</p>
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Select & Dropdowns</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                @php
                    $sports = [
                        ['value' => 'futsal', 'label' => 'Futsal'],
                        ['value' => 'minisoccer', 'label' => 'Mini Soccer'],
                        ['value' => 'badminton', 'label' => 'Badminton'],
                        ['value' => 'basketball', 'label' => 'Basket'],
                    ];

                    $cities = [
                        ['value' => 'bjm', 'label' => 'Banjarmasin'],
                        ['value' => 'bjb', 'label' => 'Banjarbaru'],
                        ['value' => 'mtp', 'label' => 'Martapura'],
                        ['value' => 'plk', 'label' => 'Palangka Raya'],
                        ['value' => 'smd', 'label' => 'Samarinda'],
                        ['value' => 'bpn', 'label' => 'Balikpapan'],
                        ['value' => 'jkt', 'label' => 'Jakarta'],
                    ];
                @endphp

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Jenis Olahraga</label>
                        <x-atoms.select
                            name="sport_type"
                            placeholder="Pilih olahraga..."
                            :options="$sports"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status Lapangan (Disabled)</label>
                        <x-atoms.select
                            name="status"
                            :options="$sports"
                            value="futsal"
                            disabled
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Lokasi Kota</label>
                        <x-atoms.select-searchable
                            name="city"
                            placeholder="Cari atau pilih kota..."
                            :options="$cities"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Lokasi Kota (Error State)</label>
                        <x-atoms.select-searchable
                            name="city_error"
                            placeholder="Cari atau pilih kota..."
                            :options="$cities"
                            :error="true"
                            errorMessage="Lokasi kota wajib dipilih."
                        />
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">File Uploads</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Unggah Bukti Transfer (User)</label>
                        <x-atoms.input-file
                            name="payment_proof"
                            accept="image/*,application/pdf"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Bukti Transfer (Error State)</label>
                        <x-atoms.input-file
                            name="payment_proof_error"
                            :error="true"
                            errorMessage="Format file tidak didukung. Harap unggah berkas gambar atau PDF."
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Unggah Berkas (Disabled)</label>
                        <x-atoms.input-file
                            name="disabled_upload"
                            disabled
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Foto Galeri Lapangan (Admin - Multiple)</label>
                        <x-atoms.input-file
                            variant="dropzone"
                            name="court_photos"
                            accept="image/*"
                            :multiple="true"
                        />
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Textarea & Selection Controls</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Deskripsi Lapangan (Admin)</label>
                        <x-atoms.input-textarea
                            name="venue_description"
                            placeholder="Masukkan info fasilitas, ukuran lapangan, kebijakan sewa, dll..."
                            rows="4"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Catatan Tambahan (Error State)</label>
                        <x-atoms.input-textarea
                            name="notes_error"
                            placeholder="Tulis instruksi tambahan..."
                            :error="true"
                            errorMessage="Deskripsi terlalu pendek, minimal 20 karakter."
                        />
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col gap-3">
                        <span class="block text-sm font-bold text-neutral-400 uppercase tracking-wider text-xs">Persetujuan & Syarat</span>
                        <x-atoms.select-checkbox name="terms" :checked="true">
                            Saya menyetujui seluruh <a href="#" class="text-primary-500 hover:underline">Syarat & Ketentuan</a> pembatalan jadwal.
                        </x-atoms.select-checkbox>
                        <x-atoms.select-checkbox name="newsletter" label="Kirim struk digital otomatis ke email saya." />
                        <x-atoms.select-checkbox name="disabled_check" label="Opsi terkunci (Disabled)" disabled />
                    </div>

                    <div class="flex flex-col gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-700">
                        <span class="block text-sm font-bold text-neutral-400 uppercase tracking-wider text-xs">Metode Pembayaran</span>
                        <div class="flex flex-wrap gap-5">
                            <x-atoms.select-radio name="payment_method" value="bca" label="Bank BCA" :checked="true" />
                            <x-atoms.select-radio name="payment_method" value="mandiri" label="Bank Mandiri" />
                            <x-atoms.select-radio name="payment_method" value="gopay" label="GoPay / QRIS" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-700">
                        <span class="block text-sm font-bold text-neutral-400 uppercase tracking-wider text-xs">Pengaturan Lapangan (Admin)</span>
                        <div class="space-y-3">
                            <div>
                                <x-atoms.select-toggle name="is_active" :checked="true" label="Status Lapangan: Buka/Aktif" />
                            </div>
                            <div>
                                <x-atoms.select-toggle name="maintenance_mode" label="Mode Perbaikan Lapangan (Maintenance)" />
                            </div>
                            <div>
                                <x-atoms.select-toggle name="toggle_disabled" label="Fitur Dinonaktifkan (Disabled)" disabled />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Status Badges</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-atoms.badge variant="success">Tersedia</x-atoms.badge>
                        <x-atoms.badge variant="danger">Penuh</x-atoms.badge>
                        <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                        <x-atoms.badge variant="info">Booking</x-atoms.badge>
                    </div>
                </div>

                <div class="dark bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-atoms.badge variant="success">Tersedia</x-atoms.badge>
                        <x-atoms.badge variant="danger">Penuh</x-atoms.badge>
                        <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                        <x-atoms.badge variant="info">Booking</x-atoms.badge>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
