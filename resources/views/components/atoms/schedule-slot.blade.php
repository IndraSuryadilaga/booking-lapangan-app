@props([
    'courtId', // Tambahkan properti ini untuk menerima ID unik lapangan
    'time',
    'price',
    'status',
    'name' => 'schedules[]',
])

@php
    $startTime = \Carbon\Carbon::parse($time);
    $endTime = (clone $startTime)->addHour();
    $timeRange = $startTime->format('H:i') . ' - ' . $endTime->format('H:i');

    $isBooked = $status === 'booked';

    $inputId = 'schedule-' . $courtId . '-' . \Illuminate\Support\Str::slug($time);
@endphp

<div class="relative w-full">
    <input
        type="checkbox"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $time }}"
        class="peer sr-only"
        @disabled($isBooked)
    >

    <label
        for="{{ $inputId }}"
        class="
            flex flex-col items-center justify-center p-2 rounded-lg border transition-all duration-200 select-none
            {{ $isBooked
                ? 'bg-neutral-50 dark:bg-neutral-800/50 border-neutral-200 dark:border-neutral-700 opacity-50 cursor-not-allowed'
                : 'bg-white dark:bg-neutral-800 border-primary-200 dark:border-primary-700 hover:border-primary-500 cursor-pointer peer-checked:bg-primary-500 dark:peer-checked:bg-primary-600 peer-checked:border-primary-600 dark:peer-checked:border-primary-500 peer-checked:shadow-md hover:shadow-sm'
            }}
        "
    >
        <span class="font-bold text-xs sm:text-sm transition-colors duration-200
            {{ $isBooked
                ? 'text-neutral-500 line-through'
                : 'text-primary-700 dark:text-primary-300 peer-checked:text-white dark:peer-checked:text-white'
            }}">
            {{ $timeRange }}
        </span>

        <span class="text-[10px] font-bold mt-0.5 transition-colors duration-200
            {{ $isBooked
                ? 'text-neutral-400'
                : 'text-emerald-600 dark:text-emerald-400 peer-checked:text-white dark:peer-checked:text-white'
            }}">
            Rp {{ number_format($price, 0, ',', '.') }}
        </span>
    </label>
</div>
