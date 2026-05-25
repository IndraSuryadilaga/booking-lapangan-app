@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => '',
    'placeholder' => 'Pilih opsi...',
    'options' => [], // Format array: [['value' => 'futsal', 'label' => 'Futsal']]
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('select-');
    $borderClass = $error
        ? 'border-danger-500 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full relative">
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            // Tambahkan class 'bg-none' di sini untuk mematikan panah bawaan tailwind forms
            'class' => "w-full rounded-full shadow-sm bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-2 sm:py-[10px] pl-4 sm:pl-6 pr-10 $borderClass appearance-none bg-none cursor-pointer focus:outline-none"
        ]) }}
    >
        @if($placeholder)
            <option value="" disabled {{ empty($value) ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $option)
            <option value="{{ $option['value'] }}" {{ $value == $option['value'] ? 'selected' : '' }}>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>

    <div class="absolute inset-y-0 right-0 pr-4 sm:pr-5 flex items-center pointer-events-none text-neutral-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </div>

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
