@props([
    'reviews' => collect(),
    'avgRating' => 0
])

@php
    $totalReviews = $reviews->count();
    $ratingVal = $totalReviews > 0 ? ($avgRating ?: $reviews->avg('rating')) : 0;

    // Kalkulasi Bintang
    $fullStars = floor($ratingVal);
    $hasHalfStar = ($ratingVal - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div
    x-data="{
        scrollNext() {
            this.$refs.scrollContainer.scrollBy({ left: 320, behavior: 'smooth' });
        },
        scrollPrev() {
            this.$refs.scrollContainer.scrollBy({ left: -320, behavior: 'smooth' });
        }
    }"
    class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 sm:p-8 shadow-sm"
>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-8">

        <div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Ulasan Pengguna</h2>
            </div>

            @if($totalReviews > 0)
                <div class="flex items-center gap-4">
                    <div class="text-4xl font-extrabold text-neutral-900 dark:text-white leading-none">
                        {{ number_format($ratingVal, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-1 text-warning-400 mb-0.5">
                            @for($i = 0; $i < $fullStars; $i++)
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                            @if($hasHalfStar)
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" fill-opacity="0.3"/><path d="M10 2.251v14.156l-3.28 2.383c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.088 11.23c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69L9.158 5.437z"/></svg>
                            @endif
                            @for($i = 0; $i < $emptyStars; $i++)
                                <svg class="size-5 text-neutral-200 dark:text-neutral-700" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Dari {{ $totalReviews }} ulasan</div>
                    </div>
                </div>
            @endif
        </div>

        @if($totalReviews > 0)
            <div class="hidden sm:flex items-center gap-2">
                <button @click="scrollPrev()" type="button" class="p-2 rounded-full border border-neutral-200 dark:border-neutral-700 text-neutral-500 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="scrollNext()" type="button" class="p-2 rounded-full border border-neutral-200 dark:border-neutral-700 text-neutral-500 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        @endif
    </div>

    <div class="relative -mx-2 px-2">
        <div
            x-ref="scrollContainer"
            class="flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-none"
            style="scrollbar-width: none;"
        >
            @forelse($reviews as $review)
                <div class="min-w-[280px] sm:min-w-[340px] max-w-[340px] bg-neutral-50/50 dark:bg-neutral-800/50 border border-neutral-200/60 dark:border-neutral-700 rounded-xl p-5 snap-start hover:shadow-md transition-shadow duration-200 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-neutral-900 dark:text-white line-clamp-1">{{ $review->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-neutral-500">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 bg-white dark:bg-neutral-800 border border-warning-200 dark:border-warning-900/30 rounded-lg px-2 py-1 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-xs font-bold text-neutral-700 dark:text-neutral-300">{{ number_format($review->rating, 1) }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed line-clamp-4">
                            "{{ $review->comment ?? 'Pemain ini memberikan penilaian yang memuaskan tanpa meninggalkan ulasan tertulis.' }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="w-full flex flex-col items-center justify-center py-10 px-4 text-center border-2 border-dashed border-neutral-200 dark:border-neutral-700 rounded-xl bg-neutral-50 dark:bg-neutral-800/50">
                    <div class="p-3 bg-white dark:bg-neutral-800 rounded-full shadow-sm mb-3">
                        <svg class="size-6 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-1">Belum Ada Ulasan</h3>
                    <p class="text-xs text-neutral-500 max-w-xs">Jadilah pemain pertama yang membagikan pengalaman bermain di lapangan ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
