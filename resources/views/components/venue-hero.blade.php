@props(['venue', 'images' => []])

@php
    $imageList = collect($images);

    if ($imageList->isEmpty() && $venue->relationLoaded('fields')) {
        $imageList = $venue->fields
            ->flatMap(fn ($field) => $field->relationLoaded('images') ? $field->images : collect())
            ->sortBy([
                fn ($image) => ! $image->is_primary,
                fn ($image) => $image->sort_order ?? 0,
            ])
            ->map(fn ($image) => $image->url)
            ->filter()
            ->unique()
            ->values();
    }

    if ($imageList->isEmpty()) {
        $imageList = collect([
            'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&h=600&fit=crop',
        ]);
    }
@endphp

    <!-- Container Utama Hero -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8"
     x-data="{
        currentIndex: 0,
        images: {{ json_encode($imageList) }},
        total() { return this.images.length; },
        next() { this.currentIndex = (this.currentIndex + 1) % this.total(); },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.total()) % this.total(); }
     }">

    <!-- Wrapper Gambar (Ukuran responsif dan sudut membulat) -->
    <div class="relative w-full h-[250px] sm:h-[400px] md:h-[500px] rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm group bg-neutral-100 dark:bg-neutral-800">

        <!-- Render Gambar dengan transisi Alpine.js -->
        <template x-for="(image, index) in images" :key="index">
            <img
                x-show="currentIndex === index"
                x-transition:enter="transition-opacity duration-500 ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-500 ease-in-out absolute inset-0"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :src="image"
                alt="Galeri Venue"
                class="absolute inset-0 w-full h-full object-cover"
            >
        </template>

        <!-- Indikator Navigasi (Persis seperti sketsa: < 1 / 3 >) -->
        <div x-show="total() > 1" style="display: none;" class="absolute bottom-4 right-4 sm:bottom-6 sm:right-6 bg-neutral-900/70 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg flex items-center gap-3 text-sm font-medium z-10 shadow-lg">

            <!-- Tombol Kiri (<) -->
            <button type="button" @click="prev()" class="hover:text-primary-400 transition-colors focus:outline-none p-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <!-- Teks Angka (1 / 3) -->
            <span class="min-w-[2.5rem] text-center select-none" x-text="(currentIndex + 1) + ' / ' + total()"></span>

            <!-- Tombol Kanan (>) -->
            <button type="button" @click="next()" class="hover:text-primary-400 transition-colors focus:outline-none p-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

        </div>

    </div>
</div>
