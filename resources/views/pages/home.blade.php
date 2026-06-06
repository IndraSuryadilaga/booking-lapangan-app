<x-app-layout>
    @php
        $categoryOptions = [['value' => '', 'label' => 'Semua Kategori']];
        if (isset($allCategories)) {
            foreach($allCategories as $cat) {
                $categoryOptions[] = ['value' => $cat->id, 'label' => $cat->name];
            }
        }

        $cityOptions = [['value' => '', 'label' => 'Semua Kota']];
        if (isset($cities)) {
            foreach($cities as $c) {
                $cityOptions[] = ['value' => $c, 'label' => $c];
            }
        }
    @endphp

    {{-- Hero Section --}}
    <div class="bg-gradient-to-b from-slate-900 to-slate-950 text-white rounded-b-3xl overflow-hidden pt-36 pb-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-primary-300 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent-400"></span>
                        Platform Booking Lapangan Terbesar
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-white tracking-tight">
                        Cari & Booking Lapangan Olahraga
                    </h1>
                    <p class="text-base sm:text-lg text-neutral-300 max-w-prose leading-relaxed">
                        Nikmati kemudahan sewa lapangan olahraga secara instan. Pilih cabang olahraga, cek jadwal ketersediaan langsung, dan bayar aman dengan berbagai metode pilihan.
                    </p>
                </div>

                <!-- Hero Visual: 1 main image + 2 floating cards -->
                <div class="hidden lg:block lg:col-span-6 relative">
                    <!-- Main visual container -->
                    <div class="w-full aspect-[1.4] rounded-2xl overflow-hidden shadow-2xl border border-slate-700/50 relative">
                        <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover brightness-90 scale-105" alt="Sports Court Preview">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent"></div>
                    </div>

                    <!-- Floating Card 1: Availability Slot (Top-Left) -->
                    <div class="absolute -top-6 -left-6 bg-white border border-slate-200 p-3 rounded-2xl shadow-xl flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider block">Futsal Court A</span>
                            <span class="text-xs font-bold text-slate-800 block mt-0.5">Tersedia 19:00 - 20:00</span>
                        </div>
                    </div>

                    <!-- Floating Card 2: Rating & Trust (Bottom-Right) -->
                    <div class="absolute -bottom-6 -right-6 bg-white border border-slate-200 p-3.5 rounded-2xl shadow-xl flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider block">Gelora Bung Karno</span>
                            <span class="text-xs font-bold text-slate-800 block mt-0.5">4.9 ★ (150+ Rating)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Overlapping Floating Search CTA Area --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <div class="bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 p-4 sm:p-5 rounded-3xl sm:rounded-full shadow-2xl max-w-4xl mx-auto">
            <form method="GET" action="{{ route('venues.index') }}" class="flex flex-col sm:flex-row gap-4 w-full items-center">
                <!-- Dropdown 1: Kategori -->
                <div class="w-full sm:flex-1 relative flex items-center">
                    <div class="w-5 h-5 absolute left-4 text-neutral-400 pointer-events-none hidden sm:block z-10">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="w-full">
                        <x-atoms.select
                            name="category[]"
                            placeholder=""
                            :options="$categoryOptions"
                            class="!pl-11"
                        />
                    </div>
                </div>

                <!-- Divider line on desktop -->
                <div class="h-8 w-px bg-slate-200 dark:bg-neutral-700 hidden sm:block"></div>

                <!-- Dropdown 2: Kota -->
                <div class="w-full sm:flex-1 relative flex items-center">
                    <div class="w-5 h-5 absolute left-4 text-neutral-400 pointer-events-none hidden sm:block z-10">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="w-full">
                        <x-atoms.select
                            name="city"
                            placeholder=""
                            :options="$cityOptions"
                            class="!pl-11"
                        />
                    </div>
                </div>

                <!-- Button -->
                <x-atoms.button type="primary" class="w-full sm:w-auto px-10 py-3 shrink-0 shadow-lg font-bold">
                    Cari Lapangan
                </x-atoms.button>
            </form>
        </div>
    </div>

    {{-- Sports Categories Showcase --}}
    <section class="mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900">Jelajahi Kategori Olahraga</h2>
                <p class="text-sm sm:text-base text-neutral-500 mt-2">Temukan lapangan berdasarkan cabang olahraga favorit Anda.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @if(isset($allCategories))
                    @foreach($allCategories as $cat)
                        @php
                            $sportName = strtolower($cat->name);
                            // Assign icons based on category name
                            $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>'; // default

                            if (str_contains($sportName, 'futsal')) {
                                $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 12h20M12 12m-3 0a3 3 0 106 0 3 3 0 10-6 0"></path></svg>';
                            } elseif (str_contains($sportName, 'badminton') || str_contains($sportName, 'bulutangkir')) {
                                $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>';
                            } elseif (str_contains($sportName, 'basket')) {
                                $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.2 6.2c2.4 2.4 2.4 6.4 0 8.8M17.8 6.2c-2.4 2.4-2.4 6.4 0 8.8M2 12h20M12 2v20"></path></svg>';
                            } elseif (str_contains($sportName, 'tennis') || str_contains($sportName, 'tenis')) {
                                $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="8" cy="12" r="4" stroke-width="2"></circle><circle cx="16" cy="12" r="4" stroke-width="2"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20"></path></svg>';
                            } elseif (str_contains($sportName, 'soccer') || str_contains($sportName, 'sepakbola')) {
                                $iconPath = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3 6.5-6.5 1.5L6 15l6 7M22 12l-6.5-3L12 12M12 2a10 10 0 0110 10M12 22a10 10 0 01-10-10"></path></svg>';
                            }
                        @endphp

                        <a href="{{ route('venues.index') }}?category[]={{ $cat->id }}" class="group block p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto rounded-2xl bg-primary-50 flex items-center justify-center text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-all duration-300 shadow-inner">
                                {!! $iconPath !!}
                            </div>
                            <h3 class="font-bold text-neutral-800 mt-4 text-base group-hover:text-primary-600 transition-colors">
                                {{ $cat->name }}
                            </h3>
                            <p class="text-xs text-neutral-400 mt-1">
                                {{ $cat->fields_count ?? 0 }} Lapangan
                            </p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section class="mt-24 py-16 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-primary-500 uppercase tracking-widest bg-primary-100/50 px-3 py-1 rounded-full">Proses Booking</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 mt-3">3 Langkah Mudah Pemesanan</h2>
                <p class="text-sm sm:text-base text-neutral-500 mt-2">Dapatkan akses ke lapangan olahraga favorit Anda dalam hitungan menit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
                <!-- Step 1 -->
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-white border border-slate-100 flex items-center justify-center text-xl font-black text-primary-500 shadow-sm relative">
                        01
                    </div>
                    <h3 class="font-bold text-neutral-800 text-lg">Pilih Lapangan</h3>
                    <p class="text-sm text-neutral-500 max-w-xs mx-auto leading-relaxed">
                        Cari lapangan berdasarkan olahraga, lokasi kota, atau nama venue favorit Anda dengan mudah.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-white border border-slate-100 flex items-center justify-center text-xl font-black text-primary-500 shadow-sm relative">
                        02
                    </div>
                    <h3 class="font-bold text-neutral-800 text-lg">Pilih Jadwal</h3>
                    <p class="text-sm text-neutral-500 max-w-xs mx-auto leading-relaxed">
                        Lihat jam operasional yang tersedia secara real-time dan tentukan waktu main terbaik Anda.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-white border border-slate-100 flex items-center justify-center text-xl font-black text-primary-500 shadow-sm relative">
                        03
                    </div>
                    <h3 class="font-bold text-neutral-800 text-lg">Bayar & Main</h3>
                    <p class="text-sm text-neutral-500 max-w-xs mx-auto leading-relaxed">
                        Konfirmasi booking Anda dengan transaksi pembayaran yang aman, lalu nikmati hari olahraga Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics & Trust --}}
    <section class="mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-md p-8 md:p-10 relative overflow-hidden">
                <!-- Subtle visual accent line at the top -->
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-primary-400 via-primary-500 to-accent-300"></div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                    <!-- Stat 1 -->
                    <div class="flex items-center gap-4 px-4 md:px-6 justify-center md:justify-start pb-4 md:pb-0">
                        <div class="w-12 h-12 rounded-full bg-primary-100/50 flex items-center justify-center text-primary-600 shrink-0 shadow-sm animate-pulse">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-3xl md:text-4xl font-black text-neutral-800 tracking-tight leading-none">{{ $totalVenues ?? '-' }}</div>
                            <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mt-1.5">Mitra Venue</div>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="flex items-center gap-4 px-4 md:px-6 justify-center md:justify-start pt-4 md:pt-0 pb-4 md:pb-0">
                        <div class="w-12 h-12 rounded-full bg-primary-100/50 flex items-center justify-center text-primary-600 shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-3xl md:text-4xl font-black text-neutral-800 tracking-tight leading-none">{{ $totalFields ?? '-' }}</div>
                            <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mt-1.5">Pilihan Lapangan</div>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="flex items-center gap-4 px-4 md:px-6 justify-center md:justify-start pt-4 md:pt-0 pb-4 md:pb-0">
                        <div class="w-12 h-12 rounded-full bg-primary-100/50 flex items-center justify-center text-primary-600 shrink-0 shadow-sm animate-pulse">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-3xl md:text-4xl font-black text-neutral-800 tracking-tight leading-none">{{ $totalUsers ?? '-' }}</div>
                            <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mt-1.5">Pengguna Aktif</div>
                        </div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="flex items-center gap-4 px-4 md:px-6 justify-center md:justify-start pt-4 md:pt-0">
                        <div class="w-12 h-12 rounded-full bg-primary-100/50 flex items-center justify-center text-primary-600 shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-3xl md:text-4xl font-black text-neutral-800 tracking-tight leading-none">{{ $totalCities ?? '-' }}</div>
                            <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mt-1.5">Kota Terjangkau</div>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges inside the statistics banner -->
                <div class="mt-8 pt-8 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-success-50 flex items-center justify-center text-success-500 shrink-0">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Mudah & Cepat</h4>
                            <p class="text-xs text-neutral-400 mt-0.5">Booking instan online tanpa perlu konfirmasi manual.</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-success-50 flex items-center justify-center text-success-500 shrink-0">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Fasilitas Terverifikasi</h4>
                            <p class="text-xs text-neutral-400 mt-0.5">Semua data venue diperbarui dan terjamin valid.</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-success-50 flex items-center justify-center text-success-500 shrink-0">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Harga Transparan</h4>
                            <p class="text-xs text-neutral-400 mt-0.5">Harga langsung dari pengelola lapangan tanpa biaya tersembunyi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-primary-500 uppercase tracking-widest bg-primary-100/50 px-3 py-1 rounded-full">Testimoni</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 mt-3">Apa Kata Pemain?</h2>
                <p class="text-sm sm:text-base text-neutral-500 mt-2">Dengarkan ulasan jujur dari komunitas olahraga yang menggunakan platform kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="border border-slate-200 rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <x-molecules.star-rating :value="5" size="sm" />
                        </div>
                        <p class="text-sm text-neutral-600 italic leading-relaxed">
                            "Sangat praktis! Dulu harus telepon satu-satu untuk tanya jadwal kosong, sekarang tinggal buka web, pilih jam, langsung bayar. Konfirmasi instan tanpa nunggu lama."
                        </p>
                    </div>
                    <div class="flex items-center gap-3.5 pt-4 mt-6 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-sm font-bold text-primary-600 shrink-0">R</div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Rian Hidayat</h4>
                            <p class="text-[10px] text-neutral-400">Pemain Futsal &bull; Banjarmasin</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="border border-slate-200 rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <x-molecules.star-rating :value="5" size="sm" />
                        </div>
                        <p class="text-sm text-neutral-600 italic leading-relaxed">
                            "Informasi lapangan terverifikasi dengan sangat baik. Foto-foto fasilitasnya sesuai asli, harganya transparan, dan CS di lapangan ramah saat klaim tiket booking."
                        </p>
                    </div>
                    <div class="flex items-center gap-3.5 pt-4 mt-6 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-sm font-bold text-primary-600 shrink-0">A</div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Amelia Putri</h4>
                            <p class="text-[10px] text-neutral-400">Pemain Badminton &bull; Banjarbaru</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="border border-slate-200 rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <x-molecules.star-rating :value="5" size="sm" />
                        </div>
                        <p class="text-sm text-neutral-600 italic leading-relaxed">
                            "Sistem reschedule-nya luar biasa membantu saat tim tiba-tiba berhalangan hadir. Pembayarannya aman dan proses verifikasinya instan."
                        </p>
                    </div>
                    <div class="flex items-center gap-3.5 pt-4 mt-6 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-sm font-bold text-primary-600 shrink-0">D</div>
                        <div>
                            <h4 class="font-bold text-neutral-800 text-sm">Dimas Pratama</h4>
                            <p class="text-[10px] text-neutral-400">Pemain Basket &bull; Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Venue Owner Collaboration --}}
    <section class="mt-24 mb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 text-white rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                    <div class="lg:col-span-7 space-y-6">
                        <div>
                            <x-atoms.badge variant="success" class="mb-4">Kemitraan Venue</x-atoms.badge>
                            <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                                Punya Lapangan Olahraga?
                            </h3>
                            <p class="text-lg sm:text-xl font-semibold text-primary-300 mt-2">
                                Kelola booking secara digital & kembangkan bisnis Anda!
                            </p>
                        </div>

                        <p class="text-sm sm:text-base text-neutral-300 leading-relaxed max-w-xl">
                            Daftarkan venue Anda sekarang untuk meraih lebih banyak pelanggan melalui platform kami. Kelola jadwal operasional, set tarif dinamis, pantau okupansi lapangan, dan terima pembayaran aman dalam satu dashboard terintegrasi.
                        </p>

                        <div class="dark pt-4">
                            <a href="{{ route('admin.venues.create') }}" class="inline-block">
                                <x-atoms.button type="primary" class="px-8 py-3 font-bold shadow-xl">
                                    Daftarkan Venue Anda
                                </x-atoms.button>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5 w-full flex justify-center">
                        <!-- Solid Mockup Dashboard (Non-glassmorphic, booking-focused) -->
                        <div class="relative w-full max-w-md bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-2xl overflow-hidden group">
                            <div class="relative space-y-5">
                                <!-- Mockup Header -->
                                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                    <div class="flex items-center gap-2.5">
                                        <!-- Mockup Owner Avatar -->
                                        <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-xs shadow-inner">
                                            V
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-xs text-white tracking-wide">Ventura Sports Arena</h4>
                                            <p class="text-[9px] text-neutral-400">Dashboard Owner &bull; Live</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20 font-semibold">Mitra Aktif</span>
                                    </div>
                                </div>

                                <!-- Stats Grid -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-slate-900 rounded-xl p-3.5 border border-slate-800">
                                        <span class="text-[9px] font-semibold text-neutral-400 block uppercase tracking-wider">Booking Hari Ini</span>
                                        <span class="text-lg font-bold text-white block mt-1">12 Pesanan</span>
                                        <span class="text-[9px] text-emerald-400 font-medium flex items-center gap-0.5 mt-0.5">
                                            100% Terverifikasi
                                        </span>
                                    </div>
                                    <div class="bg-slate-900 rounded-xl p-3.5 border border-slate-800">
                                        <span class="text-[9px] font-semibold text-neutral-400 block uppercase tracking-wider">Okupansi Jadwal</span>
                                        <span class="text-lg font-bold text-white block mt-1">85% Terisi</span>
                                        <span class="text-[9px] text-emerald-400 font-medium flex items-center gap-0.5 mt-0.5">
                                            +5% dari Kemarin
                                        </span>
                                    </div>
                                </div>

                                <!-- Weekly Schedule Simulator -->
                                <div class="space-y-2.5">
                                    <h5 class="text-[10px] font-bold text-neutral-300 uppercase tracking-wider">Status Lapangan Terkini</h5>
                                    <div class="space-y-2">
                                        <!-- Slot 1 -->
                                        <div class="flex items-center justify-between bg-slate-900 p-2 rounded-lg border border-slate-800">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] bg-emerald-500/20 text-emerald-300 font-semibold px-2 py-0.5 rounded">Futsal A</span>
                                                <span class="text-[10px] text-neutral-300 font-medium">19:00 - 20:00</span>
                                            </div>
                                            <span class="text-[9px] font-semibold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20">Penuh (Booked)</span>
                                        </div>
                                        <!-- Slot 2 -->
                                        <div class="flex items-center justify-between bg-slate-900 p-2 rounded-lg border border-slate-800">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] bg-emerald-500/20 text-emerald-300 font-semibold px-2 py-0.5 rounded">Futsal A</span>
                                                <span class="text-[10px] text-neutral-300 font-medium">20:00 - 21:00</span>
                                            </div>
                                            <span class="text-[9px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">Tersedia</span>
                                        </div>
                                        <!-- Slot 3 -->
                                        <div class="flex items-center justify-between bg-slate-900 p-2 rounded-lg border border-slate-800">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] bg-blue-500/20 text-blue-300 font-semibold px-2 py-0.5 rounded">Badminton 1</span>
                                                <span class="text-[10px] text-neutral-300 font-medium">19:00 - 20:00</span>
                                            </div>
                                            <span class="text-[9px] font-semibold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20">Penuh (Booked)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clean Daily Overview Checklist -->
                                <div class="space-y-2">
                                    <h5 class="text-[10px] font-bold text-neutral-300 uppercase tracking-wider">Aktivitas Terverifikasi</h5>
                                    <div class="bg-slate-900 p-3 rounded-xl border border-slate-800 space-y-2">
                                        <div class="flex items-start gap-2 text-xs">
                                            <span class="text-emerald-400">✓</span>
                                            <p class="text-[10px] text-neutral-300 leading-tight">Konfirmasi pembayaran otomatis sewa lapangan berhasil.</p>
                                        </div>
                                        <div class="flex items-start gap-2 text-xs">
                                            <span class="text-emerald-400">✓</span>
                                            <p class="text-[10px] text-neutral-300 leading-tight">Sinkronisasi jadwal real-time dengan aplikasi booking utama.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
