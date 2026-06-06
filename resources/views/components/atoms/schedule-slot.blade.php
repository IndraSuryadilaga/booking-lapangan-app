@props([
    'courtId',
    'time',
    'price',
    'status',
    'name' => 'schedules[]',
])

@php
    $startTime = \Carbon\Carbon::parse($time);
    $endTime = (clone $startTime)->addHour();
    $timeRange = $startTime->format('H:i') . ' - ' . $endTime->format('H:i');

    // 1. Ambil tanggal dari parameter URL (misal: ?date=2026-06-05), jika kosong gunakan hari ini
    $selectedDate = request('date', now()->format('Y-m-d'));

    // 2. Gabungkan tanggal terpilih dengan waktu slot untuk mengecek apakah sudah lewat
    $slotDateTime = \Carbon\Carbon::parse($selectedDate . ' ' . $time);
    $isPast = $slotDateTime->isPast();

    // 3. Status asli dari database
    $isBookedFromDb = in_array(strtolower($status), ['booked', 'pending', 'confirmed']);

    // 4. Blokir jadwal jika sudah dipesan ATAU waktunya sudah lewat
    $isBooked = $isBookedFromDb || $isPast;

    $inputId = 'schedule-' . $courtId . '-' . \Illuminate\Support\Str::slug($time);
@endphp

<div class="relative w-full">
    <input
        type="checkbox"
        id="{{ $inputId }}"
        name="slots[{{ $courtId }}][]"
        value="{{ $time }}|{{ $price }}"
        class="peer sr-only slot-checkbox"
        data-price="{{ $price }}"
        data-court-id="{{ $courtId }}"
        @change="calculate($event)"
        @disabled($isBooked)
    >

    <label
        for="{{ $inputId }}"
        class="
            flex flex-col items-center justify-center p-2 rounded-lg border transition-all duration-200 select-none
            {{ $isBooked
                ? 'bg-slate-50 dark:bg-neutral-800/50 border-slate-200 dark:border-neutral-700 opacity-50 cursor-not-allowed'
                : 'bg-white dark:bg-neutral-800 border-primary-200 dark:border-primary-700 hover:border-primary-500 cursor-pointer peer-checked:bg-primary-500 dark:peer-checked:bg-primary-600 peer-checked:border-primary-600 dark:peer-checked:border-primary-500 peer-checked:shadow-md hover:shadow-sm peer-checked:[&_.teks-slot]:!text-white'
            }}
        "
    >
        <span class="teks-slot font-bold text-xs sm:text-sm transition-colors duration-200
            {{ $isBooked
                ? 'text-slate-400 line-through'
                : 'text-primary-700 dark:text-primary-300'
            }}">
            {{ $timeRange }}
        </span>

        <span class="teks-slot text-[10px] font-bold mt-0.5 transition-colors duration-200
            {{ $isBooked
                ? 'text-slate-400'
                : 'text-emerald-600 dark:text-emerald-400'
            }}">
            {{-- Logika teks kecil di bawah jam --}}
            @if($isBookedFromDb)
                Tidak Tersedia
            @else
                Rp {{ number_format($price, 0, ',', '.') }}
            @endif
        </span>
    </label>
</div>
