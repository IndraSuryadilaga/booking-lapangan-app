@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => '',
    'min' => null, 
    'max' => null,
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('time-');

    // Logika warna border jika ada error
    $borderClass = $error
        ? 'border-danger-500 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full">
    <div class="relative flex items-center w-full">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400 dark:text-neutral-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <input
            type="time"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $value }}"
            {{ $min ? "min={$min}" : '' }}
            {{ $max ? "max={$max}" : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => "w-full rounded-full shadow-sm bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-2 sm:py-[10px] pl-11 pr-4 $borderClass [&::-webkit-calendar-picker-indicator]:dark:filter [&::-webkit-calendar-picker-indicator]:dark:invert"
            ]) }}
        >
    </div>

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>