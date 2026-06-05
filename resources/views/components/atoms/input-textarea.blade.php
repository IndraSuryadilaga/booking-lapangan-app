@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => null,
    'placeholder' => '',
    'rows' => 4,
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('textarea-');
    $borderClass = $error
        ? 'border-danger-500 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            'class' => "w-full rounded-2xl shadow-sm bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-3 px-4 sm:px-5 $borderClass focus:outline-none placeholder-neutral-400 dark:placeholder-neutral-500 resize-y min-h-[80px]"
        ]) }}
    >{{ $value ?? $slot }}</textarea>

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
