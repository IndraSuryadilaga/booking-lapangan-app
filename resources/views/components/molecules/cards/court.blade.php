@props([
    'court'
])

@php
    $image = $court->primary_image_url ?? 'https://via.placeholder.com/800x600';
    $name = $court->name;
    $description = $court->description;
    $sport = $court->sportsCategory->name ?? 'N/A';
    $type = $court->type ?? 'N/A';
    $material = $court->surface_material ?? 'N/A';
    $schedules = $court->schedules ?? [];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-neutral-800 rounded-xl border border-slate-200 dark:border-neutral-700 shadow-sm overflow-hidden flex flex-col md:flex-row gap-6 p-4 sm:p-6']) }}>

    <div class="w-full md:w-[45%] lg:w-[40%] flex-shrink-0 relative rounded-lg overflow-hidden group">
        <div class="relative w-full aspect-[4/3] bg-neutral-100 dark:bg-neutral-700">
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >

            <button class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-black/50 text-white rounded-full hover:bg-black/70 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-black/50 text-white rounded-full hover:bg-black/70 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <button class="absolute bottom-3 right-3 bg-black/60 hover:bg-black/80 backdrop-blur-sm text-white text-12 font-medium px-3 py-1.5 rounded-md transition-colors">
                Lihat semua foto
            </button>
        </div>
    </div>

    <div class="w-full flex flex-col flex-grow min-w-0">
        <div class="mb-4">
            <h3 class="font-bold text-lg sm:text-xl text-primary-700 dark:text-neutral-100 flex items-center gap-2 group cursor-pointer w-fit">
                {{ $name }}
                <svg class="w-4 h-4 text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">{{ $description }}</p>
        </div>

        <div class="flex flex-col gap-2.5 mb-6">
            <div class="flex items-center gap-3 text-sm text-neutral-600 dark:text-neutral-300">
                <div class="w-5 flex justify-center text-neutral-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span>{{ $sport }}</span>
            </div>

            <div class="flex items-center gap-3 text-sm text-neutral-600 dark:text-neutral-300">
                <div class="w-5 flex justify-center text-neutral-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span>{{ $type }}</span>
            </div>

            <div class="flex items-center gap-3 text-sm text-neutral-600 dark:text-neutral-300">
                <div class="w-5 flex justify-center text-neutral-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
                <span>{{ $material }}</span>
            </div>
        </div>

        <div class="flex-grow"></div>

        <div class="mt-4 pt-4 border-t border-neutral-100 dark:border-neutral-700">
            <div class="mb-4">
                <button class="inline-flex items-center gap-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors text-neutral-700 dark:text-neutral-200 px-4 py-2 rounded-lg text-sm font-semibold">
                    Tidak tersedia
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-2">
                @forelse($schedules as $schedule)
                    <div class="flex flex-col items-center p-2 rounded-lg border {{ $schedule['status'] === 'booked' ? 'bg-neutral-50 dark:bg-neutral-800/50 border-neutral-200 dark:border-neutral-700 opacity-60' : 'bg-white dark:bg-neutral-800 border-primary-200 dark:border-primary-700 hover:border-primary-500 cursor-pointer transition-colors' }}">
                        <span class="text-[10px] sm:text-xs text-neutral-400 font-medium mb-1 uppercase tracking-wider">60 Menit</span>
                        <span class="font-bold text-xs sm:text-sm {{ $schedule['status'] === 'booked' ? 'text-neutral-500' : 'text-primary-700 dark:text-primary-300' }}">{{ $schedule['time'] }}</span>

                        @if($schedule['status'] === 'booked')
                            <span class="text-[10px] font-semibold text-neutral-400 mt-0.5">Booked</span>
                        @else
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">Rp {{ number_format($schedule['price'], 0, ',', '.') }}</span>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center text-sm text-neutral-500 py-4">
                        Tidak ada jadwal tersedia.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
