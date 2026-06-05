@props([
    'title' => 'Jadwal Tersedia',
    'sportsCategories' => [],
])

<div class="flex items-center gap-4 p-4 border-b border-slate-200 dark:border-neutral-700">
    <div>
        <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-100">{{ $title }}</h2>
    </div>
</div>

<div class="bg-white dark:bg-neutral-800 rounded-xl border border-slate-200 dark:border-neutral-700 shadow-sm">
    <div class="p-4 space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                @php
                    $days = [];
                    for ($i = 0; $i < 7; $i++) {
                        $date = now()->addDays($i);
                        $days[] = [
                            'value' => $date->format('Y-m-d'),
                            'top_label' => $date->translatedFormat('D'),
                            'label' => $date->format('d'),
                        ];
                    }
                @endphp
                <x-atoms.select-slot
                    name="day_selector"
                    :options="$days"
                    :multiple="false"
                    :selected="now()->format('Y-m-d')"
                />
                <button class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700 text-gray-500 dark:text-neutral-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </button>
            </div>

            <div class="flex items-center gap-2">
                <x-atoms.select
                    name="sport_category"
                    placeholder="Jenis Olahraga"
                    :options="$sportsCategories"
                />
            </div>
        </div>
    </div>

    <div class="p-4 border-t border-slate-100 dark:border-neutral-700 space-y-4">
        <x-molecules.cards.court-card />
        <x-molecules.cards.court-card />
    </div>

    <div class="p-4 border-t border-slate-200 dark:border-neutral-700 flex justify-center">
        <div class="flex items-center space-x-2 text-sm">
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">&laquo; Prev</button>
            <span class="px-3 py-1 rounded-md bg-primary-500 text-white">1</span>
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">2</button>
            <button class="px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700">Next &raquo;</button>
        </div>
    </div>
</div>
