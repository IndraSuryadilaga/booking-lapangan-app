@props([
    'venue'
])

@php
    $selectedDate = request('date', now()->format('Y-m-d'));
    $selectedCategory = request('category', 'all');

    $showAll = request('show_all', false);

    $today = \Carbon\Carbon::today();
    $dateRange = [];
    for ($i = 0; $i < 7; $i++) {
        $dateRange[] = (clone $today)->addDays($i);
    }

    $categories = \App\Models\SportsCategory::all();

    $filteredFields = $venue->fields->filter(function($field) use ($selectedCategory) {
        return ($selectedCategory === 'all' || $field->sports_category_id == $selectedCategory) && $field->is_active;
    })->values();

    $totalFields = $filteredFields->count();

    $fieldsToDisplay = $showAll ? $filteredFields : $filteredFields->take(2);
@endphp

<div id="fields-list" class="pt-12">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Pilih Lapangan</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Pilih lapangan dan lihat jadwal yang tersedia.</p>
    </div>

    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-8">

        <div class="flex items-center bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-1.5 shadow-sm overflow-hidden w-full xl:w-auto">

            <div class="flex items-center gap-1 overflow-x-auto scrollbar-none snap-x">
                @foreach($dateRange as $day)
                    @php
                        $dateValue = $day->format('Y-m-d');
                        $isActive = $dateValue === $selectedDate;
                        $dayName = $day->translatedFormat('D');
                        $dayNumber = $day->format('d');
                    @endphp

                    <a
                        href="?date={{ $dateValue }}&category={{ $selectedCategory }}#fields-list"
                        class="flex-shrink-0 snap-start flex flex-col items-center justify-center w-[60px] py-2 rounded-lg transition-all duration-200 select-none
                            {{ $isActive
                                ? 'bg-primary-500 text-white shadow-md shadow-primary-500/20'
                                : 'bg-transparent text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-700'
                            }}"
                    >
                        <span class="text-[10px] font-semibold tracking-wide uppercase {{ $isActive ? 'text-primary-100' : '' }}">
                            {{ $dayName }}
                        </span>
                        <span class="text-lg font-bold mt-0.5 leading-none">
                            {{ $dayNumber }}
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="w-px h-8 bg-slate-200 dark:bg-neutral-700 mx-2 flex-shrink-0"></div>

            <div class="relative flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg hover:bg-primary-50 dark:hover:bg-neutral-700 text-neutral-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">

                <input
                    id="native-date-picker"
                    type="date"
                    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0 opacity-0 border-0 p-0 pointer-events-none"
                    value="{{ $selectedDate }}"
                    onchange="window.location.href = '?date=' + this.value + '&category={{ $selectedCategory }}#fields-list'"
                >

                <button
                    type="button"
                    onclick="document.getElementById('native-date-picker').showPicker()"
                    class="w-full h-full flex items-center justify-center cursor-pointer outline-none"
                    title="Pilih tanggal dari kalender"
                >
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </button>
            </div>

        </div>

        <div class="w-full xl:w-auto shrink-0">
            <select
                class="w-full xl:w-48 appearance-none bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-200 text-sm font-medium rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 shadow-sm cursor-pointer"
                onchange="window.location.href = '?date={{ $selectedDate }}&category=' + this.value + '#fields-list'"
            >
                <option value="all">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategory == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <div class="space-y-6">
            @forelse($fieldsToDisplay as $index => $field)
                <div>
                    <x-molecules.cards.court-card :court="$field" />
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-8 text-center shadow-sm">
                    <h3 class="text-xl font-semibold text-neutral-700 dark:text-neutral-200">Belum ada lapangan</h3>
                    <p class="text-sm text-neutral-500 mt-2">Venue ini belum menambahkan lapangan yang bisa dipesan atau sesuai kategori.</p>
                </div>
            @endforelse
        </div>

        @if(!$showAll && $totalFields > 2)
            <div class="flex justify-center mt-8">
                <a
                    href="?date={{ $selectedDate }}&category={{ $selectedCategory }}&show_all=1#fields-list"
                    class="inline-flex px-6 py-2.5 bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 text-primary-600 dark:text-primary-400 font-semibold text-sm rounded-xl shadow-sm hover:bg-neutral-50 dark:hover:bg-neutral-700 hover:border-primary-300 transition-all items-center gap-2 group cursor-pointer"
                >
                    Tampilkan Semua Lapangan
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
            </div>
        @endif
    </div>
</div>
