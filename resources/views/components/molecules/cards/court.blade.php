@props([
    'court' => null,
    'image' => null,
    'name' => null,
    'description' => null,
    'sport' => null,
    'type' => null,
    'material' => null,
    'schedules' => null,
])

@php
    $image = $court->primary_image_url ?? 'https://via.placeholder.com/800x600';
    $name = $court->name;
    $description = $court->description;

    // Mengambil data kategori dan icon dari database
    $sportCategory = $court->sportsCategory;
    $sportName = $sportCategory->name ?? 'N/A';
    $sportIcon = $sportCategory->icon ?? null;

    $type = $court->type ?? 'N/A';
    $material = $court->surface_material ?? 'N/A';
    $schedules = $court->schedules ?? [];
@endphp

<div x-data="{ isImageZoomed: false }" {{ $attributes->merge(['class' => 'bg-white dark:bg-neutral-800 rounded-xl border border-slate-200 dark:border-neutral-700 shadow-sm overflow-hidden flex flex-col md:flex-row gap-6 p-4 sm:p-6']) }}>

    <div class="w-full md:w-[45%] lg:w-[40%] flex-shrink-0 relative rounded-lg overflow-hidden group cursor-pointer" @click="isImageZoomed = true">
        <div class="relative w-full aspect-[4/3] bg-neutral-100 dark:bg-neutral-700">
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >

            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
        </div>
    </div>

    <div
        x-show="isImageZoomed"
        x-transition.opacity.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 md:p-8 backdrop-blur-sm"
        @keydown.escape.window="isImageZoomed = false"
        style="display: none;"
    >
        <button @click="isImageZoomed = false" class="absolute top-4 right-4 md:top-6 md:right-6 bg-white/10 hover:bg-white/20 text-white rounded-full p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img
            @click.away="isImageZoomed = false"
            src="{{ $image }}"
            alt="{{ $name }}"
            class="max-w-full max-h-full rounded-lg shadow-2xl"
        >
    </div>

    <div class="w-full flex flex-col flex-grow min-w-0">
        <div class="mb-4">
            <h3 class="font-bold text-lg sm:text-xl text-primary-700 dark:text-neutral-100 flex items-center gap-2 group w-fit">
                {{ $name }}
            </h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">{{ $description }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="inline-flex items-center gap-1.5 font-medium text-primary-500 dark:text-primary-100 bg-primary-100 dark:bg-primary-500/30 px-2.5 py-1 rounded-md text-sm shrink-0 whitespace-nowrap">
                @if($sportIcon)
                    <span
                        class="w-3.5 h-3.5 bg-current shrink-0"
                        style="
                            mask-image: url('{{ asset($sportIcon) }}');
                            mask-size: contain;
                            mask-repeat: no-repeat;
                            mask-position: center;
                            -webkit-mask-image: url('{{ asset($sportIcon) }}');
                            -webkit-mask-size: contain;
                            -webkit-mask-repeat: no-repeat;
                            -webkit-mask-position: center;
                        "
                        aria-hidden="true"
                    ></span>
                @endif
                <span>{{ $sportName }}</span>
            </span>

            <span class="inline-flex items-center font-medium text-neutral-600 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700/50 px-2.5 py-1 rounded-md text-sm capitalize shrink-0 whitespace-nowrap">
                {{ $type }}
            </span>

            <span class="inline-flex items-center font-medium text-neutral-600 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700/50 px-2.5 py-1 rounded-md text-sm capitalize shrink-0 whitespace-nowrap">
                {{ $material }}
            </span>
        </div>

        <div class="mt-4 pt-4 border-t border-neutral-100 dark:border-neutral-700">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-2">

                @forelse($schedules as $schedule)
                    <x-atoms.schedule-slot
                        :time="$schedule['time']"
                        :price="$schedule['price']"
                        :status="$schedule['status']"
                    />
                @empty
                    <div class="col-span-full text-center text-sm text-neutral-500 py-4">
                        Tidak ada jadwal tersedia.
                    </div>
                @endforelse

            </div>
        </div>
        </div>

    </div>
</div>
