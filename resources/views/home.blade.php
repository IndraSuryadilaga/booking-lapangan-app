<x-app-layout>
    <div class="bg-gradient-to-r from-gray-900 via-blue-950 to-slate-900 text-white rounded-2xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Temukan lapangan terbaik di sekitarmu</h1>
                    <p class="mt-4 text-lg text-gray-200 max-w-prose">Booking lapangan mudah, cepat, dan aman. Pilih jenis olahraga, lihat fasilitas, dan cek jadwal langsung.</p>

                    <div class="mt-8 space-y-4">
                        <form method="GET" action="{{ route('venues.index') }}" class="flex gap-3 flex-wrap">
                            <select name="category[]" class="rounded-md border-gray-200 px-3 py-2">
                                <option value="">Semua Kategori</option>
                                @if(isset($allCategories))
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            <select name="city" class="rounded-md border-gray-200 px-3 py-2">
                                <option value="">Semua Kota</option>
                                @if(isset($cities))
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                @endif
                            </select>

                            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full font-semibold bg-primary-400 text-white hover:bg-primary-500">Cari Lapangan</button>
                        </form>

                        <div class="flex gap-3">
                            <a href="{{ route('venues.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full font-semibold bg-white text-primary-600 hover:bg-white/90">Lihat Katalog</a>
                            <a href="#popular" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full font-semibold bg-white/10 text-white">Venue Populer</a>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    {{-- decorative image or illustration placeholder --}}
                    <div class="w-full aspect-[16/10] bg-gradient-to-tr from-white/5 to-white/2 rounded-xl"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Feature section --}}
    <section class="mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600">
                            {{-- icon --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Mudah & Cepat</h3>
                            <p class="text-sm text-neutral-500 mt-1">Proses booking singkat tanpa ribet.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Fasilitas Terpercaya</h3>
                            <p class="text-sm text-neutral-500 mt-1">Venue terverifikasi dengan fasilitas lengkap.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zM12 14v6"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Harga Transparan</h3>
                            <p class="text-sm text-neutral-500 mt-1">Harga mulai dari lapangan yang jelas dan dapat dibandingkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Popular venues --}}
    <section id="popular" class="mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold">Venue Populer</h2>
                    <p class="text-sm text-neutral-500">Dipilih berdasarkan rating pengguna.</p>
                </div>
                <a href="{{ route('venues.index') }}" class="text-sm text-primary-600">Lihat semua</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($popularVenues as $venue)
                    @php
                        $image = $venue->logo_url ?? 'https://via.placeholder.com/400x500';
                        $sport = $venue->sportsCategories->first()->name ?? 'Multi';
                        $price = 0;
                    @endphp

                    <x-venue-card :venue="$venue" />
                @empty
                    <div class="col-span-full text-center py-8">Belum ada venue populer.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Statistics --}}
    <section class="mt-12 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold">{{ $totalVenues ?? '-' }}</div>
                    <div class="text-sm text-neutral-500">Venue</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold">{{ $totalFields ?? '-' }}</div>
                    <div class="text-sm text-neutral-500">Lapangan</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold">{{ $totalUsers ?? '-' }}</div>
                    <div class="text-sm text-neutral-500">Pengguna</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold">{{ $totalCities ?? '-' }}</div>
                    <div class="text-sm text-neutral-500">Kota</div>
                </div>
            </div>

            @if(!empty($fieldsPerCategory) && $fieldsPerCategory->isNotEmpty())
                <div class="mt-6 bg-white border border-slate-200 rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Jumlah Lapangan per Kategori</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($fieldsPerCategory as $cat)
                            <div class="flex items-center justify-between px-4 py-2 border rounded-md">
                                <div class="text-sm font-medium">{{ $cat['name'] }}</div>
                                <div class="text-sm text-neutral-500">{{ $cat['count'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Venue Owner Collaboration --}}
    <section class="mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary-700 text-white rounded-xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-bold">Jadi Mitra Venue</h3>
                    <p class="mt-2 text-sm">Daftarkan venue Anda dan raih lebih banyak pelanggan melalui platform kami. Kelola jadwal, harga, dan fasilitas dengan mudah.</p>
                </div>

                <div>
                    <a href="{{ route('admin.venues.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-primary-700 rounded-full font-semibold">Daftarkan Venue Anda</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
