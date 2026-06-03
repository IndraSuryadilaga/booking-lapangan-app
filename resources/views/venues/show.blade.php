<x-app-layout>
    <div class="pt-24 sm:pt-20 pb-12">
        <x-venue-hero :venue="$venue" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI (Lebih Besar - Span 2) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Kotak Informasi Utama (Menggunakan divide-y untuk garis pemisah) --}}
                    <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl overflow-hidden divide-y divide-slate-200 dark:divide-neutral-700 shadow-sm">

                        {{-- Baris 1: Logo, Nama, Rating, Kategori --}}
                        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6">
                            {{-- Logo Venue --}}
                            <div class="w-24 h-24 sm:w-28 sm:h-28 shrink-0 rounded-2xl overflow-hidden border border-slate-100 dark:border-neutral-700 shadow-sm bg-neutral-50 dark:bg-neutral-800">
                                <img
                                    src="{{ $venue->logo}}"
                                    alt="Logo {{ $venue->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            {{-- Info Utama --}}
                            <div class="flex-1">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 dark:text-white mb-2 leading-tight">
                                    {{ $venue->name }}
                                </h1>

                                {{-- Rating & Lokasi --}}
                                <div class="flex flex-wrap items-center gap-3 text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-warning-400" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                                        <span class="font-bold text-neutral-900 dark:text-white">{{ $venue->rating_avg ?? '4.5' }}</span>
                                    </div>
                                    <span class="text-neutral-300 dark:text-neutral-600">&bull;</span>
                                    <div class="flex items-center gap-1">
                                        <span>{{ $venue->city ?? 'Kota Depok, Jawa Barat' }}</span>
                                    </div>
                                </div>

                                {{-- Badges Olahraga --}}
                                <div class="flex flex-wrap gap-2">
                                    @forelse($venue->sportsCategories ?? [] as $cat)
                                        <x-atoms.badge-sport
                                            :name="$cat->name"
                                            :icon="$cat->icon ?? null"
                                        />
                                    @empty
                                        <x-atoms.badge-sport name="Multi-Sport" />
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Baris 2: Deskripsi --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Deskripsi</h2>
                            <div class="prose prose-sm sm:prose-base prose-neutral dark:prose-invert max-w-none text-neutral-600 dark:text-neutral-400">
                                <p>{{ $venue->description ?? 'Tidak ada deskripsi yang tersedia untuk venue ini.' }}</p>
                            </div>
                        </div>

                        {{-- Baris 3: Aturan Venue --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Aturan Venue</h2>
                            <div class="prose prose-sm sm:prose-base prose-neutral dark:prose-invert max-w-none text-neutral-600 dark:text-neutral-400">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>{{ $venue->refund_policy ?? 'Tidak ada informasi kebijakan pembatalan.' }}</li>
                                    <li>{{ $venue->reschedule_policy ?? 'Dilarang merokok di dalam area lapangan.' }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Baris 4: Fasilitas --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Fasilitas</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-6">
                                {{-- Contoh Looping Fasilitas --}}
                                @forelse($venue->facilities ?? [] as $facility)
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    <span class="w-5 h-5 text-neutral-400">
                                        {!! $facility->icon_svg ?? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' !!}
                                    </span>
                                        {{ $facility->name }}
                                    </div>
                                @empty
                                    {{-- Dummy Data jika kosong (Sesuai Referensi Gambar) --}}
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Cafe & Resto
                                    </div>
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Jual Makanan Ringan
                                    </div>
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        Musholla
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                {{-- KOLOM KANAN (Lebih Kecil - Span 1) --}}
                <div class="lg:col-span-1">
                    {{-- Sticky Wrapper agar sidebar diam saat di-scroll --}}
                    <div class="sticky top-24 space-y-6">

                        {{-- Kotak Peta Lokasi --}}
                        <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-4 sm:p-6 shadow-sm">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Peta Lokasi Venue</h2>
                            <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-700 border border-slate-200 dark:border-neutral-600">
                                @if($venue->latitude && $venue->longitude)
                                    <iframe class="w-full h-full" frameborder="0" loading="lazy" src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"></iframe>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-neutral-400">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-sm">Peta tidak tersedia</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Kotak Harga & CTA --}}
                        <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm">
                            <div class="text-sm text-neutral-500 dark:text-neutral-400 font-medium mb-1">Mulai dari</div>
                            <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">
                                Rp {{ number_format($venue->price_start ?? 100000, 0, ',', '.') }}
                            </span>
                                <span class="text-sm text-neutral-500 dark:text-neutral-400">Per Sesi</span>
                            </div>

                            {{-- Tombol CTA mengarah ke section #fields-list (Daftar Lapangan) --}}
                            <a href="#fields-list" class="block w-full">
                                <x-atoms.button type="primary" class="w-full justify-center py-3">
                                    Cek Ketersediaan
                                </x-atoms.button>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            {{-- DAFTAR LAPANGAN --}}
            <x-organisms.court-catalog :venue="$venue" />

            <div class="mt-16 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 sm:p-8 shadow-sm">

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Ulasan</h2>
                    </div>
                    <a href="#" class="text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400">Lihat semua ulasan</a>
                </div>

                <div class="flex items-end gap-4 mb-8">
                    <div class="text-4xl sm:text-5xl font-extrabold text-neutral-900 dark:text-white">
                        4.8<span class="text-xl sm:text-2xl text-neutral-400 font-bold">/5</span>
                    </div>
                    <div class="pb-1 sm:pb-2">
                        <div class="flex items-center gap-1 text-warning-400 mb-1">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                            @endfor
                        </div>
                        <div class="text-xs sm:text-sm text-neutral-500">62 rating • 14 ulasan</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @php
                        $criteria = [
                            ['name' => 'Kebersihan', 'score' => 4.94, 'percent' => '98%'],
                            ['name' => 'Kondisi Lapangan', 'score' => 4.71, 'percent' => '94%'],
                            ['name' => 'Komunikasi', 'score' => 4.82, 'percent' => '96%'],
                        ];
                    @endphp
                    @foreach($criteria as $item)
                        <div>
                            <div class="flex justify-between text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                <span>{{ $item['name'] }}</span>
                                <span>{{ $item['score'] }}</span>
                            </div>
                            <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-1.5">
                                <div class="bg-primary-600 h-1.5 rounded-full" style="width: {{ $item['percent'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="relative">
                    <div class="flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
                        <div class="min-w-[300px] sm:min-w-[400px] bg-white dark:bg-neutral-800 border border-slate-100 dark:border-neutral-700 rounded-xl p-5 snap-start shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-neutral-200 overflow-hidden">
                                        <img src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?w=100&h=100&fit=crop" class="w-full h-full object-cover" alt="User">
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-neutral-900 dark:text-white">Rafael Alberto Satria</div>
                                        <div class="text-xs text-neutral-500">Diulas: 06 May 2026</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 border border-slate-200 dark:border-neutral-600 rounded-md px-2 py-1">
                                    <svg class="w-3 h-3 text-warning-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <span class="text-xs font-bold">5.0</span>
                                </div>
                            </div>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4 line-clamp-3">
                                mungkin bisa dipertimbangkan lagi untuk air kamar mandi padel supaya tidak terlalu berkaporit. terima kasih
                            </p>
                            <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">PADEL</span>
                        </div>

                        <div class="min-w-[300px] sm:min-w-[400px] bg-white dark:bg-neutral-800 border border-slate-100 dark:border-neutral-700 rounded-xl p-5 snap-start shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        ML
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-neutral-900 dark:text-white">Mirza Rima Lovita</div>
                                        <div class="text-xs text-neutral-500">Diulas: 24 April 2026</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 border border-slate-200 dark:border-neutral-600 rounded-md px-2 py-1">
                                    <svg class="w-3 h-3 text-warning-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <span class="text-xs font-bold">4.7</span>
                                </div>
                            </div>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4 line-clamp-3">
                                dengan harga segitu lumayan lah, dan terutama toilet bersih 👍🏼
                            </p>
                            <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">PADEL</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-16 mb-8"
                 x-data="{
        scrollNext() {
            let slider = this.$refs.slider;
            slider.scrollBy({ left: 340, behavior: 'smooth' });
        },
        scrollPrev() {
            let slider = this.$refs.slider;
            slider.scrollBy({ left: -340, behavior: 'smooth' });
        }
     }"
            >
                <div class="flex items-end justify-between mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Rekomendasi venue lainnya</h2>

                    @if($venues->isNotEmpty())
                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="scrollPrev()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 shadow-sm hover:bg-neutral-50 dark:hover:bg-neutral-700 text-neutral-600 dark:text-neutral-300 transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click="scrollNext()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 shadow-sm hover:bg-neutral-50 dark:hover:bg-neutral-700 text-neutral-600 dark:text-neutral-300 transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    @endif
                </div>

                @if($venues->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl p-8 text-center shadow-sm">
                        <h3 class="text-xl font-semibold">Tidak ditemukan venue</h3>
                        <p class="text-sm text-neutral-500 mt-2">Coba ubah filter Anda atau hapus beberapa kriteria pencarian.</p>
                    </div>
                @else
                    <div class="relative -mx-4 px-4 sm:mx-0 sm:px-0">
                        <div
                            x-ref="slider"
                            class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-4"
                            style="scrollbar-width: none; -ms-overflow-style: none;"
                        >
                            <style>
                                [x-ref="slider"]::-webkit-scrollbar { display: none; }
                            </style>

                            @foreach($venues as $recommendedVenue)
                                <div class="shrink-0 w-[85vw] sm:w-[320px] snap-start">
                                    <x-molecules.cards.venue :venue="$recommendedVenue" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
