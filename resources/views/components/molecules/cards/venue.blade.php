@props([
    'image' => 'https://via.placeholder.com/400x500',
    'name',
    'rating' => null,
    'sport',
    'location',
    'price',
    'url' => '#'
])

<a href="{{ $url }}" class="block group text-current decoration-transparent">
    <div {{ $attributes->merge(['class' => 'bg-white dark:bg-neutral-600 rounded-xl border border-slate-200 dark:border-neutral-500 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full']) }}>

        <div class="relative w-full aspect-[4/3] sm:aspect-[4/5] overflow-hidden bg-neutral-100 dark:bg-neutral-700">
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
        </div>

        <div class="p-4 flex flex-col flex-grow">
            <h3 class="font-bold text-18 text-primary-700 dark:text-neutral-100 leading-tight mb-2 line-clamp-2 group-hover:text-accent-300 transition-colors">
                {{ $name }}
            </h3>

            <div class="flex items-center justify-start text-14 text-neutral-500 dark:text-neutral-300 mb-4 gap-2">
                @if($rating)
                    <svg class="w-3.5 h-3.5 text-warning-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold text-12 sm:text-sm leading-none">{{ $rating }}</span>
                @endif

                <div class="flex items-center gap-1.5 min-w-0">
                    <span class="text-neutral-300 dark:text-neutral-500 shrink-0">&bull;</span>
                    <span class="font-semibold truncate text-xs sm:text-sm">{{ $location }}</span>
                </div>
            </div>

            <div class="flex items-center justify-start text-sm text-neutral-500 dark:text-neutral-300 mb-4 gap-2">
                <span class="font-medium text-primary-500 dark:text-primary-100 bg-primary-100 dark:bg-primary-500/30 px-2 py-0.5 rounded-md text-12 shrink-0">
                    {{ $sport }}
                </span>
            </div>

            <div class="flex-grow"></div>

            <div class="flex items-center justify-start pt-3 border-t border-neutral-100 dark:border-neutral-500 mt-auto gap-1">
                <span class="font-medium text-12 text-neutral-500 dark:text-neutral-200">Harga mulai</span>
                <span class="font-extrabold text-14 text-black dark:text-white">
                    Rp {{ number_format($price, 0, ',', '.') }}
                </span>
                <span class="font-medium text-12 text-neutral-500 dark:text-neutral-200">/sesi</span>
            </div>
        </div>
    </div>
</a>
