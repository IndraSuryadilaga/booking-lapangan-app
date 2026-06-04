@props([
    'venue' => null,
    'image' => null,
    'name' => 'Nama Venue Default',
    'rating' => 'N/A',
    'sport' => null,
    'sports' => [],
    'location' => 'Lokasi Default',
    'price' => null,
    'url' => '#',
])

@if($venue)
    @php
        $logo = $venue->logo_url ?? 'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop';
        $name = $venue->name;
        $rating = $venue->rating_avg;
        $location = $venue->city;
        $url = route('venues.show', $venue->slug);
        $sports = $venue->sportsCategories;

        $lowestPrice = $venue->fields
            ->flatMap(fn ($field) => $field->pricings)
            ->min('price_per_slot');
    @endphp
@else
    @php
        $logo = $image ?? 'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop';
        $lowestPrice = $price;
    @endphp
@endif

<a href="{{ $url }}" class="block group text-current decoration-transparent">
    <div {{ $attributes->merge(['class' => 'bg-white dark:bg-neutral-600 rounded-xl border border-slate-200 dark:border-neutral-500 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full']) }}>

        <div class="relative w-full aspect-[4/3] sm:aspect-[4/5] overflow-hidden bg-neutral-100 dark:bg-neutral-700">
            <img
                src="{{ $logo }}"
                alt="{{ $name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
        </div>

        <div class="p-4 flex flex-col flex-grow">
            <h3 class="font-bold text-18 text-primary-700 dark:text-neutral-100 leading-tight mb-2 line-clamp-2 group-hover:text-accent-300 transition-colors">
                {{ $name }}
            </h3>

            <div class="flex items-center justify-start text-14 text-neutral-500 dark:text-neutral-300 mb-4 gap-2">
                @if($rating && $rating !== 'N/A')
                    <svg class="w-3.5 h-3.5 text-warning-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold text-12 sm:text-sm leading-none">{{ number_format($rating, 1) }}</span>
                @endif

                <div class="flex items-center gap-1.5 min-w-0">
                    @if($rating && $rating !== 'N/A')
                        <span class="text-neutral-300 dark:text-neutral-500 shrink-0">&bull;</span>
                    @endif
                    <span class="font-semibold truncate text-xs sm:text-sm">{{ $location }}</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-start text-sm text-neutral-500 dark:text-neutral-300 mb-4 gap-2">
                @php
                    $sportsCollection = collect($sports);
                @endphp

                @if($sport)
                    <x-atoms.badge-sport :name="$sport" />
                @endif

                @foreach($sportsCollection->take(3) as $sportItem)
                    <x-atoms.badge-sport
                        :name="$sportItem->name"
                        :icon="$sportItem->icon"
                    />
                @endforeach

                @if($sportsCollection->count() > 3)
                    <x-atoms.badge-sport :name="'+' . ($sportsCollection->count() - 3)" />
                @endif
            </div>

            <div class="flex-grow"></div>

            <div class="flex items-center justify-start pt-3 border-t border-neutral-100 dark:border-neutral-500 mt-auto gap-1">
                @if($lowestPrice)
                    <span class="font-medium text-12 text-neutral-500 dark:text-neutral-200">Harga mulai</span>
                    <span class="font-extrabold text-14 text-black dark:text-white">
                        Rp {{ number_format($lowestPrice, 0, ',', '.') }}
                    </span>
                    <span class="font-medium text-12 text-neutral-500 dark:text-neutral-200">/sesi</span>
                @else
                    <span class="font-medium text-12 text-neutral-500 dark:text-neutral-200">Harga belum tersedia</span>
                @endif
            </div>
        </div>
    </div>
</a>
