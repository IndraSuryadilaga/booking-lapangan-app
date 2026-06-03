@props([
    'title' => 'Jadwal Tersedia',
])

<div class="bg-white dark:bg-neutral-800 rounded-xl border border-slate-200 dark:border-neutral-700 shadow-sm">
    {{-- 1. Header Komponen --}}
    <div class="flex items-center gap-4 p-4 border-b border-slate-200 dark:border-neutral-700">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
            {{-- Ikon Play --}}
            <svg class="w-6 h-6 text-red-500 dark:text-red-400" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5v14l11-7z" />
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-100">{{ $title }}</h2>
            <p class="text-sm text-gray-500 dark:text-neutral-400">Pilih jadwal yang paling sesuai untuk Anda.</p>
        </div>
    </div>

    {{-- 2. Baris Kontrol --}}
    <div class="p-4 space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            {{-- Selektor 7 Hari --}}
            <div class="flex items-center gap-2">
                <div class="flex -space-x-px">
                    {{-- Ini akan kita buat dinamis nanti --}}
                    <x-atoms.select-toggle type="button" checked="true">Sen</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Sel</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Rab</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Kam</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Jum</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Sab</x-atoms.select-toggle>
                    <x-atoms.select-toggle type="button">Min</x-atoms.select-toggle>
                </div>
                {{-- Ikon Kalender --}}
                <button class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700 text-gray-500 dark:text-neutral-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </button>
            </div>

            {{-- Filter Kanan --}}
            <div class="flex items-center gap-2">
                <x-atoms.time-filter />
                <x-atoms.select name="sort_by" :options="[['value' => 'terdekat', 'label' => 'Waktu Terdekat'], ['value' => 'termurah', 'label' => 'Harga Termurah']]" />
            </div>
        </div>
    </div>

    {{-- 3. Area Konten (Hasil Pencarian) --}}
    <div class="p-4 border-t border-slate-100 dark:border-neutral-700 space-y-4">
        {{-- Looping Card akan di sini --}}
        <x-molecules.cards.court />
        <x-molecules.cards.court />
    </div>

    {{-- 4. Pagination --}}
    <div class="p-4 border-t border-slate-200 dark:border-neutral-700 flex justify-center">
        {{-- Placeholder untuk pagination --}}
        <div class="flex items-center space-x-2 text-sm">
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">&laquo; Prev</button>
            <span class="px-3 py-1 rounded-md bg-primary-500 text-white">1</span>
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">2</button>
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">Next &raquo;</button>
        </div>
    </div>
</div>
