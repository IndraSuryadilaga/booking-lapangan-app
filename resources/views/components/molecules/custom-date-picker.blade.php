@props([
    'selectedDate' => now()->format('Y-m-d'),
    'selectedCategory' => 'all',
    'fullyBookedDates' => []
])

<div
    x-data="{
        isOpen: false,
        currentDate: new Date('{{ $selectedDate }}'),
        selectedDate: '{{ $selectedDate }}',
        fullyBookedDates: @js($fullyBookedDates),

        today: new Date().toISOString().split('T')[0],

        get maxDate() {
            let d = new Date();
            d.setMonth(d.getMonth() + 2);
            return d.toISOString().split('T')[0];
        },

        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        daysInMonth: [],
        blankDays: [],

        initCalendar() {
            let year = this.currentDate.getFullYear();
            let month = this.currentDate.getMonth();

            let firstDayOfWeek = new Date(year, month, 1).getDay();
            let daysNum = new Date(year, month + 1, 0).getDate();

            this.blankDays = Array.from({ length: firstDayOfWeek }, (_, i) => i);
            this.daysInMonth = Array.from({ length: daysNum }, (_, i) => i + 1);
        },

        formatDateString(day) {
            let yyyy = this.currentDate.getFullYear();
            let mm = String(this.currentDate.getMonth() + 1).padStart(2, '0');
            let dd = String(day).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        },

        prevMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.currentDate = new Date(this.currentDate);
            this.initCalendar();
        },

        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.currentDate = new Date(this.currentDate);
            this.initCalendar();
        },

        selectDate(day) {
            this.selectedDate = this.formatDateString(day);
            this.isOpen = false;
            window.location.href = `?date=${this.selectedDate}&category={{ $selectedCategory }}#fields-list`;
        },

        get formattedSelectedDate() {
            let d = new Date(this.selectedDate);
            return `${d.getDate()} ${this.monthNames[d.getMonth()]} ${d.getFullYear()}`;
        },

        isFullyBooked(day) {
            return this.fullyBookedDates.includes(this.formatDateString(day));
        }
    }"
    x-init="initCalendar()"
    @click.away="isOpen = false"
    :class="{ 'z-50 relative': isOpen, 'z-10 relative': !isOpen }"
    class="inline-block text-left"
>
    <button
        type="button"
        @click="isOpen = !isOpen"
        class="inline-flex items-center gap-2 px-4 py-4 text-sm font-medium text-neutral-700 dark:text-neutral-200 bg-white dark:bg-neutral-800 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700 shadow-xs transition-colors cursor-pointer outline-hidden focus:ring-2 focus:ring-primary-500"
    >
        <svg class="w-4 h-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span x-text="formattedSelectedDate"></span>
        <svg class="w-4 h-4 text-neutral-400 transition-transform duration-200" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 z-50 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-xl"
        style="display: none;"
    >
        <div class="flex items-center justify-between pb-3 border-b border-neutral-100 dark:border-neutral-700/50 mb-3">
            <span class="text-xs font-bold text-neutral-900 dark:text-white" x-text="monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear()"></span>
            <div class="flex gap-0.5">
                <button type="button" @click="prevMonth()" class="p-1 rounded-md text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-white transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button" @click="nextMonth()" class="p-1 rounded-md text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-white transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mb-2">
            <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
        </div>

        <div class="grid grid-cols-7 gap-1">
            <template x-for="blank in blankDays" :key="'blank-'+blank">
                <div class="aspect-square"></div>
            </template>

            <template x-for="day in daysInMonth" :key="'day-'+day">
                <div class="aspect-square flex items-center justify-center">
                    <button
                        type="button"
                        @click="selectDate(day)"
                        :disabled="formatDateString(day) < today || formatDateString(day) > maxDate || isFullyBooked(day)"
                        :class="{
                            'bg-primary-600 text-white font-semibold shadow-xs ring-2 ring-primary-300 dark:ring-primary-900 ring-offset-1 dark:ring-offset-neutral-800': selectedDate === formatDateString(day),
                            'text-primary-600 dark:text-primary-400 font-bold border border-primary-200 dark:border-primary-800/60': today === formatDateString(day) && selectedDate !== formatDateString(day),
                            'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700/60': selectedDate !== formatDateString(day) && formatDateString(day) >= today && formatDateString(day) <= maxDate && today !== formatDateString(day),
                            'text-neutral-300 dark:text-neutral-600 cursor-not-allowed opacity-40 line-through': formatDateString(day) < today || formatDateString(day) > maxDate
                        }"
                        class="w-7 h-7 rounded-lg text-xs flex items-center justify-center transition-all duration-100 outline-hidden"
                        x-text="day"
                    ></button>
                </div>
            </template>
        </div>
    </div>
</div>
