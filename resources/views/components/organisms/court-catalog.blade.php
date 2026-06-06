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

<div id="fields-list">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Pilih Lapangan</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Pilih lapangan dan lihat jadwal yang tersedia.</p>
    </div>

    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-8">
        <div class="flex items-center bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-xl p-1.5 shadow-sm w-full xl:w-auto">
            <div class="flex items-center gap-1  scrollbar-none snap-x">
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

            <div class="relative z-40">
                <x-molecules.custom-date-picker
                    :selectedDate="$selectedDate"
                    :selectedCategory="$selectedCategory"
                    :fullyBookedDates="$fullyBookedDates ?? []"
                />
            </div>
        </div>

        <div class="w-full xl:w-48" x-data @input="window.location.href = '?date={{ $selectedDate }}&category=' + $event.detail + '#fields-list'">
            <x-atoms.select
                name="category"
                placeholder="Semua Kategori"
                :value="$selectedCategory"
                :options="$categories->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->prepend(['value' => 'all', 'label' => 'Semua Kategori'])->toArray()"
            />
        </div>
    </div>

    <div x-data="bookingCart()">
        <form action="{{ route('bookings.init') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_date" value="{{ $selectedDate }}">

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

            <div x-cloak x-show="selectedCount > 0"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-full"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-full"
                 class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-[0_-10px_20px_-5px_rgba(0,0,0,0.1)] z-50 p-4 md:p-6">

                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-sm text-neutral-500 font-medium">Total Pembayaran</p>
                        <p class="text-xl sm:text-2xl font-extrabold text-primary-700">
                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(totalPrice)"></span>
                        </p>
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        <span>Lanjut Pembayaran</span>
                        <span class="bg-white/20 px-2 py-0.5 rounded-md text-sm" x-text="selectedCount + ' Sesi'"></span>
                    </button>
                </div>
            </div>
        </form>

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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bookingCart', () => ({
            selectedCount: 0,
            totalPrice: 0,
            currentCourtId: null, // Mengingat ID lapangan yang sedang dipilih

            calculate(event) {
                const clickedCheckbox = event.target;
                const courtId = clickedCheckbox.dataset.courtId;

                if (clickedCheckbox.checked) {
                    // Jika user klik jadwal di lapangan yang BEDA dari sebelumnya
                    if (this.currentCourtId !== null && this.currentCourtId !== courtId) {

                        // Hapus/uncheck semua centang di lapangan sebelumnya otomatis
                        document.querySelectorAll('.slot-checkbox:checked').forEach(el => {
                            if (el.dataset.courtId !== courtId) {
                                el.checked = false;
                            }
                        });

                        // (Opsional) Kamu bisa memunculkan alert jika mau:
                        // alert('Anda hanya bisa memesan satu lapangan dalam 1 transaksi. Pilihan sebelumnya telah dibatalkan.');
                    }
                    // Update lapangan aktif saat ini
                    this.currentCourtId = courtId;
                }

                const checkedSlots = Array.from(document.querySelectorAll('.slot-checkbox:checked'));
                this.selectedCount = checkedSlots.length;
                this.totalPrice = checkedSlots.reduce((sum, el) => sum + parseInt(el.dataset.price || 0), 0);

                if (this.selectedCount === 0) {
                    this.currentCourtId = null;
                }
            }
        }))
    })
</script>
