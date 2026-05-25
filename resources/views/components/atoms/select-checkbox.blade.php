@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => '1',
    'checked' => false,
    'label' => null,
])

@php
    $id = $id ?? $name ?? uniqid('checkbox-');
@endphp

<label for="{{ $id }}" class="inline-flex items-start gap-3 cursor-pointer select-none group" :class="{'opacity-60 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}}">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            'class' => "w-[18px] h-[18px] rounded-md border-neutral-300 dark:border-neutral-700 text-primary-500 shadow-sm focus:ring-primary-500/30 focus:ring-offset-0 bg-white dark:bg-neutral-900 transition-all duration-150 disabled:bg-neutral-100 dark:disabled:bg-neutral-800"
        ]) }}
    >
    @if($label || $slot->isNotEmpty())
        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors leading-tight">
            {{ $label ?? $slot }}
        </span>
    @endif
</label>
