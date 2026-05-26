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
        <input
            type="time"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $value }}"
            {{ $min ? "min={$min}" : '' }}
            {{ $max ? "max={$max}" : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => "w-full text-center rounded-full shadow-sm bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-2 sm:py-[10px] px-4 $borderClass [&::-webkit-calendar-picker-indicator]:dark:filter [&::-webkit-calendar-picker-indicator]:dark:invert [&::-webkit-datetime-edit]:flex [&::-webkit-datetime-edit]:justify-center [&::-webkit-datetime-edit]:items-center"
            ]) }}
        >
    </div>

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>