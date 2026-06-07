<x-app-layout>
    {{-- Hero Section --}}
    <div class="bg-gradient-to-br from-neutral-700 via-[#031530] to-neutral-700 text-white rounded-b-[48px] overflow-hidden pt-36 pb-32 relative shadow-sm">
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-primary-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-80 h-80 rounded-full bg-accent-400/5 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-white border border-white/20 uppercase tracking-wider">
                        Platform Booking Lapangan Terbesar
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-black leading-tight text-white tracking-tight">
                        Cari & Booking<br>Lapangan <span class="text-accent-300">Olahraga.</span>
                    </h1>
                    <p class="text-lg text-primary-100 max-w-lg leading-relaxed opacity-90">
                        Nikmati kemudahan sewa lapangan olahraga secara instan. Pilih cabang olahraga, cek jadwal ketersediaan langsung, dan bayar aman.
                    </p>
                </div>

                <div class="hidden lg:block lg:col-span-6 relative">
                    <div class="w-full aspect-[4/3] rounded-[40px] overflow-hidden shadow-2xl border border-white/10 relative group">
                        <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Sports Court Preview">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-950/60 via-transparent to-transparent"></div>
                    </div>

                    <div class="absolute -top-8 -left-8 bg-white/90 backdrop-blur-lg border border-white p-4 rounded-[24px] shadow-xl flex items-center gap-4 hover:-translate-y-1 transition-transform duration-300">
                        <div class="w-12 h-12 rounded-[16px] bg-accent-100 flex items-center justify-center text-accent-600 shrink-0 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold text-neutral-400 uppercase tracking-widest block">Futsal Court A</span>
                            <span class="text-sm font-bold text-neutral-700 block mt-0.5">Tersedia 19:00 - 20:00</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-8 -right-8 bg-white/90 backdrop-blur-lg border border-white p-4 rounded-[24px] shadow-xl flex items-center gap-4 hover:-translate-y-1 transition-transform duration-300">
                        <div class="w-12 h-12 rounded-[16px] bg-warning-100 flex items-center justify-center text-warning-500 shrink-0 shadow-inner">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold text-neutral-400 uppercase tracking-widest block">Gelora Bung Karno</span>
                            <span class="text-sm font-bold text-neutral-700 block mt-0.5">4.9 ★ (150+ Ulasan)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search CTA Area --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="bg-white p-4 sm:p-6 rounded-[32px] sm:rounded-[40px] shadow-xl shadow-neutral-200/50 border border-neutral-100">
            <form method="GET" action="{{ route('venues.index') }}" class="flex flex-col sm:flex-row gap-4 w-full items-center">
                <div class="w-full sm:flex-1 relative flex items-center">
                    <div class="w-full">
                        <x-atoms.select
                            name="category[]"
                            placeholder=""
                            :options="$categoryOptions"
                        />
                    </div>
                </div>

                <div class="w-full sm:flex-1 relative flex items-center">
                    <div class="w-full">
                        <x-atoms.select
                            name="city"
                            placeholder=""
                            :options="$cityOptions"
                        />
                    </div>
                </div>

                <x-atoms.button type="primary">
                    Cari Lapangan
                </x-atoms.button>
            </form>
        </div>
    </div>

    {{-- Sports Categories Showcase --}}
    <section class="mt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-800 tracking-tight">Kategori <span class="text-primary-500">Olahraga</span></h2>
                <p class="text-base text-neutral-500 mt-4">Pilih dan temukan lapangan berdasarkan cabang olahraga favorit Anda.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @if(isset($allCategories))
                    @foreach($allCategories as $cat)
                        <a href="{{ route('venues.index') }}?category[]={{ $cat->id }}" class="group block p-6 bg-white border border-neutral-100 rounded-[32px] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-primary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>

                            <div class="w-16 h-16 mx-auto rounded-[20px] bg-neutral-50 flex items-center justify-center text-neutral-400 group-hover:bg-primary-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-md">
                                @if($cat->icon)
                                    @if(str_contains($cat->icon, '<svg'))
                                        <span class="w-8 h-8 flex items-center justify-center shrink-0 [&>svg]:w-8 [&>svg]:h-8 transition-colors duration-300">
                                            {!! $cat->icon !!}
                                        </span>
                                    @else
                                        <span
                                            class="w-8 h-8 bg-neutral-400 group-hover:bg-white shrink-0 transition-colors duration-300"
                                            style="
                                            mask-image: url('{{ asset($cat->icon) }}');
                                            mask-size: contain;
                                            mask-repeat: no-repeat;
                                            mask-position: center;
                                            -webkit-mask-image: url('{{ asset($cat->icon) }}');
                                            -webkit-mask-size: contain;
                                            -webkit-mask-repeat: no-repeat;
                                            -webkit-mask-position: center;"
                                            aria-hidden="true"
                                        ></span>
                                    @endif
                                @else
                                    <svg class="w-8 h-8 text-neutral-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                @endif
                            </div>

                            <h3 class="font-extrabold text-neutral-700 mt-5 text-lg group-hover:text-primary-600 transition-colors">
                                {{ $cat->name }}
                            </h3>
                            <p class="text-sm font-medium text-neutral-400 mt-1">
                                {{ $cat->fields_count ?? 0 }} Lapangan
                            </p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section class="mt-32 py-24 bg-neutral-50 rounded-[48px] max-w-[96%] mx-auto relative border border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs font-bold text-accent-500 uppercase tracking-widest bg-accent-100 px-4 py-2 rounded-full inline-block mb-4">Proses Booking</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-800 tracking-tight">3 Langkah <span class="text-primary-500">Instan</span></h2>
                <p class="text-base text-neutral-500 mt-4">Dapatkan akses ke lapangan olahraga favorit Anda dalam hitungan menit tanpa ribet.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-neutral-200 border-t-2 border-dashed border-neutral-300 -z-10"></div>

                <div class="text-center space-y-5 bg-white p-8 rounded-[32px] shadow-sm border border-neutral-100 relative">
                    <div class="w-20 h-20 mx-auto rounded-[24px] bg-primary-100 flex items-center justify-center text-3xl font-black text-primary-600 shadow-sm rotate-3 hover:rotate-0 transition-transform">
                        1
                    </div>
                    <div>
                        <h3 class="font-extrabold text-neutral-700 text-xl">Pilih Lapangan</h3>
                        <p class="text-sm text-neutral-500 mt-3 leading-relaxed">Cari lapangan berdasarkan olahraga, lokasi kota, atau nama venue favorit Anda dengan mudah.</p>
                    </div>
                </div>

                <div class="text-center space-y-5 bg-white p-8 rounded-[32px] shadow-sm border border-neutral-100 relative">
                    <div class="w-20 h-20 mx-auto rounded-[24px] bg-primary-100 flex items-center justify-center text-3xl font-black text-primary-600 shadow-sm -rotate-3 hover:rotate-0 transition-transform">
                        2
                    </div>
                    <div>
                        <h3 class="font-extrabold text-neutral-700 text-xl">Tentukan Jadwal</h3>
                        <p class="text-sm text-neutral-500 mt-3 leading-relaxed">Lihat jam operasional yang tersedia secara real-time dan tentukan waktu main terbaik Anda.</p>
                    </div>
                </div>

                <div class="text-center space-y-5 bg-white p-8 rounded-[32px] shadow-sm border border-neutral-100 relative">
                    <div class="w-20 h-20 mx-auto rounded-[24px] bg-primary-100 flex items-center justify-center text-3xl font-black text-primary-600 shadow-sm rotate-3 hover:rotate-0 transition-transform">
                        3
                    </div>
                    <div>
                        <h3 class="font-extrabold text-neutral-700 text-xl">Bayar & Main</h3>
                        <p class="text-sm text-neutral-500 mt-3 leading-relaxed">Konfirmasi booking Anda dengan transaksi yang aman, lalu bersiaplah untuk berkeringat!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics & Trust --}}
    <section class="mt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary-600 rounded-[40px] shadow-xl p-10 md:p-14 relative overflow-hidden text-white">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-700 to-primary-500"></div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>

                <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-0 divide-y md:divide-y-0 md:divide-x divide-white/20">
                    <div class="text-center px-4">
                        <div class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-md">{{ $totalVenues ?? '50+' }}</div>
                        <div class="text-xs font-bold text-primary-200 uppercase tracking-widest mt-2">Mitra Venue</div>
                    </div>

                    <div class="text-center px-4 pt-8 md:pt-0">
                        <div class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-md">{{ $totalFields ?? '200+' }}</div>
                        <div class="text-xs font-bold text-primary-200 uppercase tracking-widest mt-2">Pilihan Lapangan</div>
                    </div>

                    <div class="text-center px-4 pt-8 md:pt-0">
                        <div class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-md">{{ $totalUsers ?? '5K+' }}</div>
                        <div class="text-xs font-bold text-primary-200 uppercase tracking-widest mt-2">Pemain Aktif</div>
                    </div>

                    <div class="text-center px-4 pt-8 md:pt-0">
                        <div class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-md">{{ $totalCities ?? '10+' }}</div>
                        <div class="text-xs font-bold text-primary-200 uppercase tracking-widest mt-2">Kota Jangkauan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="mt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-primary-500 uppercase tracking-widest bg-primary-100 px-4 py-2 rounded-full inline-block mb-4">Ulasan Pemain</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-800 tracking-tight">Apa Kata <span class="text-accent-500">Mereka?</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white border border-neutral-100 rounded-[32px] p-8 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-6">
                        <x-molecules.star-rating :value="5" size="sm" class="text-warning-400" />
                        <p class="text-base text-neutral-600 font-medium leading-relaxed group-hover:text-neutral-800 transition-colors">
                            "Sangat praktis! Dulu harus telepon satu-satu untuk tanya jadwal kosong, sekarang tinggal buka web, pilih jam, langsung bayar."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-8 border-t border-neutral-100">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-lg font-black text-primary-600 shrink-0">R</div>
                        <div>
                            <h4 class="font-extrabold text-neutral-700 text-sm">Rian Hidayat</h4>
                            <p class="text-xs font-medium text-neutral-400">Futsal &bull; Banjarmasin</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-neutral-100 rounded-[32px] p-8 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group transform md:-translate-y-4">
                    <div class="space-y-6">
                        <x-molecules.star-rating :value="5" size="sm" class="text-warning-400" />
                        <p class="text-base text-neutral-600 font-medium leading-relaxed group-hover:text-neutral-800 transition-colors">
                            "Informasi lapangan terverifikasi dengan sangat baik. Foto-foto fasilitasnya sesuai asli, dan harganya transparan."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-8 border-t border-neutral-100">
                        <div class="w-12 h-12 rounded-full bg-accent-100 flex items-center justify-center text-lg font-black text-accent-600 shrink-0">A</div>
                        <div>
                            <h4 class="font-extrabold text-neutral-700 text-sm">Amelia Putri</h4>
                            <p class="text-xs font-medium text-neutral-400">Badminton &bull; Banjarbaru</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-neutral-100 rounded-[32px] p-8 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-6">
                        <x-molecules.star-rating :value="5" size="sm" class="text-warning-400" />
                        <p class="text-base text-neutral-600 font-medium leading-relaxed group-hover:text-neutral-800 transition-colors">
                            "Sistem reschedule-nya luar biasa membantu. Pembayarannya aman dan proses verifikasinya instan langsung dari HP."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-8 border-t border-neutral-100">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-lg font-black text-primary-600 shrink-0">D</div>
                        <div>
                            <h4 class="font-extrabold text-neutral-700 text-sm">Dimas Pratama</h4>
                            <p class="text-xs font-medium text-neutral-400">Basket &bull; Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Venue Owner Collaboration --}}
    <section class="mt-32 mb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-neutral-900 rounded-[48px] p-8 md:p-14 shadow-2xl relative overflow-hidden border border-neutral-800">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-600/20 rounded-full blur-[100px] pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
                    <div class="lg:col-span-6 space-y-8">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-success-500/20 text-success-400 border border-success-500/30 uppercase tracking-wider mb-6">
                                Kemitraan Venue Aktif
                            </div>
                            <h3 class="text-4xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                                Punya Lapangan<br><span class="text-primary-400">Olahraga?</span>
                            </h3>
                        </div>

                        <p class="text-base text-neutral-400 leading-relaxed max-w-lg">
                            Daftarkan venue Anda sekarang untuk meraih lebih banyak pelanggan. Kelola jadwal, set tarif dinamis, pantau okupansi, dan terima pembayaran secara otomatis dalam satu dashboard digital.
                        </p>

                        <div class="pt-4">
                            <a href="{{ route('admin.venues.create') }}" class="inline-block">
                                <x-atoms.button type="primary" class="px-10 py-4 font-bold text-lg rounded-2xl shadow-xl shadow-primary-900/50">
                                    Daftarkan Venue Sekarang
                                </x-atoms.button>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-6 w-full flex justify-center lg:justify-end">
                        <div class="relative w-full max-w-sm bg-neutral-800/80 backdrop-blur-xl border border-neutral-700 rounded-[32px] p-6 shadow-2xl">
                            <div class="space-y-6">
                                <div class="flex items-center justify-between pb-4 border-b border-neutral-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-[12px] bg-primary-500 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                                            V
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-white">Ventura Arena</h4>
                                            <p class="text-[10px] text-neutral-400">Dashboard Owner</p>
                                        </div>
                                    </div>
                                    <span class="w-2 h-2 rounded-full bg-success-400 animate-pulse"></span>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-neutral-900/50 rounded-2xl p-4 border border-neutral-700/50">
                                        <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Pendapatan</span>
                                        <span class="text-xl font-black text-white block mt-1">+Rp 2.4M</span>
                                    </div>
                                    <div class="bg-neutral-900/50 rounded-2xl p-4 border border-neutral-700/50">
                                        <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Booking</span>
                                        <span class="text-xl font-black text-white block mt-1">12 Sesi</span>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h5 class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Live Status</h5>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between bg-neutral-900/50 p-3 rounded-xl border border-neutral-700/50">
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] bg-primary-500/20 text-primary-300 font-bold px-2 py-1 rounded-md">Futsal A</span>
                                                <span class="text-[11px] font-medium text-neutral-300">19:00 WIB</span>
                                            </div>
                                            <span class="text-[10px] font-bold text-success-400 bg-success-500/10 px-2.5 py-1 rounded-full">Booked</span>
                                        </div>
                                        <div class="flex items-center justify-between bg-neutral-900/50 p-3 rounded-xl border border-neutral-700/50">
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] bg-accent-500/20 text-accent-300 font-bold px-2 py-1 rounded-md">Basket B</span>
                                                <span class="text-[11px] font-medium text-neutral-300">20:00 WIB</span>
                                            </div>
                                            <span class="text-[10px] font-bold text-neutral-400 bg-neutral-500/10 px-2.5 py-1 rounded-full">Tersedia</span>
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
