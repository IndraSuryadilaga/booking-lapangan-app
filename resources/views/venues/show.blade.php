<x-app-layout>
    <div class="pt-24 sm:pt-20 pb-12 ">
        <x-organisms.venue-hero :venue="$venue" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-12 lg:space-y-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KIRI: Detail Info (Span 2) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl overflow-hidden divide-y divide-slate-200 dark:divide-neutral-700 shadow-sm">

                        {{-- Header Info --}}
                        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 shrink-0 rounded-2xl overflow-hidden border border-slate-100 dark:border-neutral-700 shadow-sm bg-neutral-50 dark:bg-neutral-800">
                                <img
                                    src="{{ $venue->logo ?? 'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop' }}"
                                    alt="Logo {{ $venue->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="flex-1">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 dark:text-white mb-2 leading-tight">
                                    {{ $venue->name }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-warning-400" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                                        <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($venue->reviews?->avg('rating') ?? 0, 1) }}</span>
                                    </div>
                                    <span class="text-neutral-300 dark:text-neutral-600">•</span>
                                    <div class="flex items-center gap-1">
                                        <span>{{ $venue->city ?? 'Kota Depok, Jawa Barat' }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($venue->sportsCategories ?? [] as $cat)
                                        <x-atoms.badge type="sport" :name="$cat->name" :icon="$cat->icon ?? null" />
                                    @empty
                                        <x-atoms.badge type="sport" name="Multi-Sport" />
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Deskripsi</h2>
                            <div class="prose prose-sm sm:prose-base prose-neutral dark:prose-invert max-w-none text-neutral-600 dark:text-neutral-400">
                                <p>{{ $venue->description ?? 'Tidak ada deskripsi yang tersedia untuk venue ini.' }}</p>
                            </div>
                        </div>

                        {{-- Aturan Venue --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Aturan Venue</h2>
                            <div class="prose prose-sm sm:prose-base prose-neutral dark:prose-invert max-w-none text-neutral-600 dark:text-neutral-400">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>{{ $venue->refund_policy ?? 'Tidak ada informasi kebijakan pembatalan.' }}</li>
                                    <li>{{ $venue->reschedule_policy ?? 'Dilarang merokok di dalam area lapangan.' }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Fasilitas --}}
                        <div class="p-6 sm:p-8">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Fasilitas</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-6">
                                @forelse($venue->facilities ?? [] as $facility)
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        <span class="w-5 h-5 text-neutral-400">{!! $facility->icon_svg ?? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' !!}</span>
                                        {{ $facility->name }}
                                    </div>
                                @empty
                                    <div class="flex items-center gap-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Cafe & Resto
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Peta & Harga (Span 1) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        {{-- Peta --}}
                        <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-4 sm:p-6 shadow-sm">
                            <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Peta Lokasi Venue</h2>
                            <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-700 border border-slate-200 dark:border-neutral-600">
                                @if($venue->latitude && $venue->longitude)
                                    <iframe class="w-full h-full" frameborder="0" loading="lazy" src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"></iframe>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-neutral-400">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        <span class="text-sm">Peta tidak tersedia</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Harga & CTA --}}
                        <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm">
                            <div class="text-sm text-neutral-500 dark:text-neutral-400 font-medium mb-1">Mulai dari</div>
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">Rp {{ number_format($venue->price_start ?? 100000, 0, ',', '.') }}</span>
                                <span class="text-sm text-neutral-500 dark:text-neutral-400">Per Sesi</span>
                            </div>
                            <a href="#fields-list" class="block w-full">
                                <x-atoms.button type="primary" class="w-full justify-center py-3">Cek Ketersediaan</x-atoms.button>
                            </a>
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
                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Ulasan</h2>
                        </div>
                    </div>

                    @php
                        $reviewsCollection = $venue->reviews ?? collect();
                        $avgRating = $venue->rating_avg ?? $reviewsCollection->avg('rating') ?? 0;
                        $totalReviews = $reviewsCollection->count();
                    @endphp

                    <div class="flex items-end gap-4 mb-8">
                        <div class="text-4xl sm:text-5xl font-extrabold text-neutral-900 dark:text-white">
                            {{ number_format($avgRating, 1) }}<span class="text-xl sm:text-2xl text-neutral-400 font-bold">/5</span>
                        </div>
                        <div class="pb-1 sm:pb-2">
                            @php
                                $fullStars = floor($avgRating);
                                $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp
                            <div class="flex items-center gap-1 text-warning-400 mb-1">
                                @for($i = 0; $i < $fullStars; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                                @endfor
                                @if($hasHalfStar)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" style="clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);"/></svg>
                                @endif
                                @for($i = 0; $i < $emptyStars; $i++)
                                    <svg class="w-5 h-5 text-neutral-300" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                            <div class="text-xs sm:text-sm text-neutral-500">{{ $totalReviews }} ulasan</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @php
                            $ratingVal = $avgRating;
                            $kebersihan = min(5.0, $ratingVal + 0.1);
                            $kondisi = max(1.0, $ratingVal - 0.1);
                            $komunikasi = $ratingVal;

                            $criteria = [
                                ['name' => 'Kebersihan', 'score' => number_format($kebersihan, 2), 'percent' => ($kebersihan / 5) * 100 . '%'],
                                ['name' => 'Kondisi Lapangan', 'score' => number_format($kondisi, 2), 'percent' => ($kondisi / 5) * 100 . '%'],
                                ['name' => 'Komunikasi', 'score' => number_format($komunikasi, 2), 'percent' => ($komunikasi / 5) * 100 . '%'],
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
                        <div class="flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide" style="scrollbar-width: none;">
                            <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>

                            @forelse($venue->reviews ?? [] as $review)
                                <div class="min-w-[300px] sm:min-w-[400px] bg-white dark:bg-neutral-800 border border-slate-100 dark:border-neutral-700 rounded-xl p-5 snap-start shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-sm text-neutral-900 dark:text-white">{{ $review->user->name ?? 'Guest' }}</div>
                                                <div class="text-xs text-neutral-500">Diulas: {{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d M Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 border border-slate-200 dark:border-neutral-600 rounded-md px-2 py-1">
                                            <svg class="w-3 h-3 text-warning-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            <span class="text-xs font-bold">{{ number_format($review->rating, 1) }}</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4 line-clamp-3">
                                        {{ $review->comment ?? 'Penilaian tanpa ulasan tertulis.' }}
                                    </p>
                                </div>
                            @empty
                                <div class="w-full text-center py-8 text-sm text-neutral-500 border-2 border-dashed border-slate-200 rounded-xl">
                                    Belum ada ulasan untuk venue ini. Jadilah yang pertama memberikan ulasan!
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

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
