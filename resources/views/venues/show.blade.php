<x-app-layout>
    <div class="pt-24 sm:pt-20 pb-12 ">
        <x-organisms.venue-hero :venue="$venue" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-12 lg:space-y-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Detail Info (Sisi Kiri) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-xs overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-700">

                        {{-- Header Info --}}
                        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6 bg-gradient-to-br from-white via-white to-neutral-50/50 dark:from-neutral-800 dark:via-neutral-800 dark:to-neutral-900/20">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 shrink-0 rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-xs bg-white dark:bg-neutral-900 p-1">
                                <img
                                    src="{{ $venue->logo ?? 'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop' }}"
                                    alt="Logo {{ $venue->name }}"
                                    class="w-full h-full object-cover rounded-xl"
                                >
                            </div>

                            <div class="flex-1 min-w-0">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 dark:text-white mb-2.5 leading-tight tracking-tight">
                                    {{ $venue->name }}
                                </h1>

                                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                    <div class="flex items-center gap-1 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-lg text-xs font-bold ring-1 ring-amber-200 dark:ring-amber-900/50">
                                        <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>{{ number_format($venue->reviews?->avg('rating') ?? 0, 1) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate">{{ $venue->city ?? 'Kota Depok, Jawa Barat' }}</span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2 text-10 text-xs">
                                    @forelse($venue->fieldSportCategories as $cat)
                                        <x-atoms.badge type="sport" :name="$cat->name" :icon="$cat->icon ?? null" />
                                    @empty
                                        <x-atoms.badge type="sport" name="Multi-Sport" />
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-base font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 mb-3">Tentang Venue</h2>
                            <div class="text-sm sm:text-base text-neutral-700 dark:text-neutral-300 leading-relaxed max-w-prose">
                                {{ $venue->description ?? 'Tidak ada deskripsi yang tersedia untuk venue ini.' }}
                            </div>
                        </div>

                        {{-- Kebijakan Transaksi & Aturan Lapangan --}}
                        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Tata Tertib Bermain
                                </h3>
                                <ul class="text-sm text-neutral-600 dark:text-neutral-400 space-y-3">
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-neutral-600 mt-1.5 size-1.5 rounded-full shrink-0 bg-current"></span>
                                        <span>Dilarang merokok di dalam area arena olahraga.</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-neutral-600 mt-1.5 size-1.5 rounded-full shrink-0 bg-current"></span>
                                        <span>Wajib menggunakan sepatu olahraga yang sesuai dengan tipe lapangan.</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Kebijakan Transaksi
                                </h3>
                                <ul class="text-sm text-neutral-600 dark:text-neutral-400 space-y-3">
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-neutral-600 mt-1.5 size-1.5 rounded-full shrink-0 bg-current"></span>
                                        <span class="leading-relaxed">
                                            <strong class="text-neutral-900 dark:text-white font-semibold">Refund:</strong>
                                            {{ $venue->refund_policy ?? 'Tidak ada informasi kebijakan pengembalian dana.' }}
                                        </span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-neutral-600 mt-1.5 size-1.5 rounded-full shrink-0 bg-current"></span>
                                        <span class="leading-relaxed">
                                            <strong class="text-neutral-900 dark:text-white font-semibold">Reschedule:</strong>
                                            {{ $venue->reschedule_policy ?? 'Perubahan jadwal dapat dilakukan maksimal H-1 sesi.' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Fasilitas Tersedia --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 text-xs mb-4">Fasilitas Tersedia</h2>

                            <div class="flex flex-wrap gap-2.5 text-xs">
                                @forelse($venue->facilities ?? [] as $facility)
                                    <x-atoms.badge
                                        type="facility"
                                        :name="$facility->name"
                                        :icon="$facility->icon"
                                    />
                                @empty
                                    <x-atoms.badge
                                        type="facility"
                                        name="Cafe & Resto"
                                    >
                                        <x-slot:icon>
                                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </x-slot:icon>
                                    </x-atoms.badge>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 h-full">
                    <div class="sticky top-24 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl shadow-sm overflow-hidden flex flex-col h-full divide-y divide-neutral-200 dark:divide-neutral-700">

                        {{-- CTA Booking --}}
                        <div class="p-6 relative overflow-hidden group bg-gradient-to-br from-white to-neutral-50/30 dark:from-neutral-800 dark:to-neutral-900/10">
                            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary-500/5 dark:bg-primary-500/10 rounded-full blur-xl transition-transform duration-500 group-hover:scale-150"></div>

                            <div class="text-xs text-neutral-400 dark:text-neutral-500 font-bold uppercase tracking-wider mb-1">Mulai dari</div>
                            <div class="flex items-baseline gap-1.5 mb-6">
                                <span class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                                    Rp {{ number_format($venue->price_start ?? 100000, 0, ',', '.') }}
                                </span>
                                <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">/ slot</span>
                            </div>

                            <a href="#fields-list" class="block w-full">
                                <x-atoms.button type="primary" class="w-full">
                                    Cek Jadwal Lapangan
                                </x-atoms.button>
                            </a>
                        </div>

                        {{-- Peta Lokasi --}}
                        <div
                            x-data="{
                                address: '{{ $venue->address ?? 'Jl. Merdeka No. 10, ' . ($venue->city ?? 'Kota Depok') }}',
                                copied: false,
                                copyToClipboard() {
                                    navigator.clipboard.writeText(this.address);
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                }
                            }"
                            class="p-6 flex-1 flex flex-col justify-between space-y-4"
                        >
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider">Lokasi Arena</h2>
                                    @if($venue->latitude && $venue->longitude)
                                        <a
                                            href="https://www.google.com/maps/search/?api=1&query={{ $venue->latitude }},{{ $venue->longitude }}"
                                            target="_blank"
                                            class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1"
                                        >
                                            Petunjuk Rute
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif
                                </div>

                                {{-- Iframe Map --}}
                                <div class="h-full w-full aspect-[16/11] lg:aspect-auto lg:flex-1 min-h-[180px] rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700">
                                    @if($venue->latitude && $venue->longitude)
                                        <iframe
                                            class="w-full h-full dark:invert-[0.9] dark:hue-rotate-180"
                                            frameborder="0"
                                            loading="lazy"
                                            allowfullscreen
                                            src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"
                                        ></iframe>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-neutral-400 p-4 text-center">
                                            <svg class="w-6 h-6 mb-2 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            <span class="text-xs font-medium">Titik koordinat peta belum diatur oleh pengelola.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Teks Alamat & Tombol Klik Salin di Bagian Paling Bawah Kartu --}}
                            <div class="pt-2 border-t border-neutral-100 dark:border-neutral-700/50">
                                <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed font-medium line-clamp-2 mb-2" x-text="address"></p>
                                <button
                                    type="button"
                                    @click="copyToClipboard()"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-bold tracking-wide uppercase text-neutral-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-hidden"
                                >
                                    <template x-if="!copied">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    </template>
                                    <template x-if="copied">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                    <span :class="copied ? 'text-emerald-600 dark:text-emerald-400 font-bold' : ''" x-text="copied ? 'Alamat Tersalin!' : 'Salin Alamat Lengkap'"></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{--  COURT CATALOG --}}
            <div id="fields-list" class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <x-organisms.court-catalog :venue="$venue" :fullyBookedDates="$fullyBookedDates" />
            </div>

            {{-- REVIEWS & REKOMENDASI --}}
            <div class="space-y-12 lg:space-y-16">

                {{-- 4A. Ulasan --}}
                <x-molecules.reviews-section
                    :reviews="$venue->reviews ?? collect()"
                    :avgRating="$venue->rating_avg ?? 0"
                />

                {{-- 4B. Rekomendasi Venue --}}
                <div x-data="{
                        scrollNext() { this.$refs.slider.scrollBy({ left: 340, behavior: 'smooth' }); },
                        scrollPrev() { this.$refs.slider.scrollBy({ left: -340, behavior: 'smooth' }); }
                     }">
                    <div class="flex items-end justify-between mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Rekomendasi venue lainnya</h2>
                        @if($venues->isNotEmpty())
                            <div class="flex items-center gap-2 shrink-0">
                                <button @click="scrollPrev()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-200 shadow-sm hover:bg-neutral-50"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                <button @click="scrollNext()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-200 shadow-sm hover:bg-neutral-50"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
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
                            <div x-ref="slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                                <style>[x-ref="slider"]::-webkit-scrollbar { display: none; }</style>
                                @foreach($venues as $recommendedVenue)
                                    <div class="shrink-0 w-[85vw] sm:w-[320px] snap-start">
                                        <x-molecules.cards.venue-card :venue="$recommendedVenue" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            {{-- END OF SECTION 4 --}}

        </div>
    </div>
</x-app-layout>
