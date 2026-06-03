<x-app-layout>
    <div class="bg-neutral-900 text-white rounded-b-3xl sm:rounded-b-[3rem] overflow-hidden relative shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-700/80 to-neutral-900 z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 z-0 mix-blend-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-white">
                        Temukan lapangan <span class="text-primary-300">terbaik</span> di sekitarmu
                    </h1>
                    <p class="mt-4 text-lg text-neutral-300 max-w-prose">
                        Booking lapangan mudah, cepat, dan aman. Pilih jenis olahraga, lihat fasilitas, dan cek jadwal langsung.
                    </p>

                    <div class="mt-8 space-y-6">
                        <form method="GET" action="{{ route('venues.index') }}" class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 flex flex-col sm:flex-row gap-3">

                            @php
                                // Konversi data Object/Array dari controller ke format array yang diminta x-atoms.select
                                $categoryOptions = isset($allCategories)
                                    ? collect($allCategories)->map(fn($cat) => ['value' => $cat->id, 'label' => $cat->name])->toArray()
                                    : [];

                                $cityOptions = isset($cities)
                                    ? collect($cities)->map(fn($c) => ['value' => $c, 'label' => $c])->toArray()
                                    : [];
                            @endphp

                            <div class="flex-1">
                                <x-atoms.select
                                    name="category"
                                    placeholder="Semua Kategori"
                                    :options="$categoryOptions"
                                    class="!bg-white/90"
                                />
                            </div>

                            <div class="flex-1">
                                <x-atoms.select-searchable
                                    name="city"
                                    placeholder="Semua Kota"
                                    :options="$cityOptions"
                                />
                            </div>

                            <x-atoms.button type="primary" class="shrink-0 w-full sm:w-auto h-full">
                                Cari Lapangan
                            </x-atoms.button>
                        </form>

                        <div class="flex gap-3 flex-wrap">
                            <a href="{{ route('venues.index') }}">
                                <x-atoms.button type="secondary">Lihat Katalog</x-atoms.button>
                            </a>
                            <a href="#popular">
                                <x-atoms.button type="text" class="text-white hover:bg-white/10 hover:text-white">Venue Populer</x-atoms.button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block relative">
                    <div class="w-full aspect-[4/3] bg-gradient-to-tr from-primary-500/20 to-accent-300/20 rounded-2xl border border-white/10 overflow-hidden shadow-lg transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Padel Court" class="w-full h-full object-cover opacity-80 mix-blend-luminosity hover:mix-blend-normal transition-all duration-500">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 dark:text-white">Mudah & Cepat</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Proses booking instan tanpa konfirmasi manual.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 dark:text-white">Fasilitas Terpercaya</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Venue terverifikasi dengan data fasilitas yang valid.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zM12 14v6m-3-3h6"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 dark:text-white">Harga Transparan</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Harga kompetitif tanpa ada biaya tersembunyi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="popular" class="mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 dark:text-white">Venue Populer</h2>
                    <p class="mt-1 text-neutral-500 dark:text-neutral-400">Pilihan favorit para pemain minggu ini.</p>
                </div>
                <a href="{{ route('venues.index') }}" class="group inline-flex items-center text-sm font-bold text-primary-500 hover:text-primary-600 dark:text-primary-400">
                    Lihat semua katalog
                    <svg class="ml-1 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($popularVenues ?? [] as $venue)
                    <x-molecules.cards.venue :venue="$venue" />
                @empty
                    <div class="col-span-full bg-neutral-50 dark:bg-neutral-800/50 border border-dashed border-neutral-300 dark:border-neutral-700 rounded-2xl py-12 flex flex-col items-center justify-center text-center">
                        <svg class="w-12 h-12 text-neutral-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-neutral-500 dark:text-neutral-400 font-medium">Belum ada venue populer saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mt-20 mb-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary-50 dark:bg-neutral-900 border border-primary-100 dark:border-neutral-800 rounded-3xl p-8 sm:p-12 relative overflow-hidden">
                <svg class="absolute right-0 top-0 text-primary-100 dark:text-neutral-800 w-64 h-64 transform translate-x-1/3 -translate-y-1/4" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 relative z-10">
                    <div class="text-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-primary-600 dark:text-primary-400">{{ $totalVenues ?? '0' }}</div>
                        <div class="mt-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">Mitra Venue</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-primary-600 dark:text-primary-400">{{ $totalFields ?? '0' }}</div>
                        <div class="mt-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">Pilihan Lapangan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-primary-600 dark:text-primary-400">{{ $totalUsers ?? '0' }}</div>
                        <div class="mt-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">Pengguna Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-primary-600 dark:text-primary-400">{{ $totalCities ?? '0' }}</div>
                        <div class="mt-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">Kota Terjangkau</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-neutral-900 text-white rounded-3xl p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-600/30 to-transparent z-0"></div>

                <div class="relative z-10 max-w-xl">
                    <h3 class="text-3xl font-extrabold mb-3">Punya Lapangan Olahraga?</h3>
                    <p class="text-neutral-300 text-lg">
                        Daftarkan venue Anda sekarang. Kelola jadwal, tingkatkan pemesanan, dan raih lebih banyak pelanggan melalui platform kami secara gratis.
                    </p>
                </div>

                <div class="relative z-10 shrink-0">
                    <a href="{{ route('admin.venues.create') }}">
                        <x-atoms.button type="primary" class="!px-8 !py-4 !text-lg !bg-white !text-neutral-900 hover:!bg-neutral-200">
                            Daftarkan Venue
                        </x-atoms.button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
