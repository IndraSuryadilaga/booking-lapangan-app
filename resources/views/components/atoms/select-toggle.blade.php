@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'checked' => false,
    'label' => null,
    'value' => '1',
])

@php
    $id = $id ?? $name ?? uniqid('toggle-');
@endphp

<div x-data="{ isActive: {{ $checked ? 'true' : 'false' }} }" class="inline-flex items-center">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        x-model="isActive"
        {{ $disabled ? 'disabled' : '' }}
        class="hidden"
    >

    <label
        @click="if(!{{ $disabled ? 'true' : 'false' }}) isActive = !isActive"
        class="inline-flex items-center gap-3 cursor-pointer select-none group"
        :class="{'opacity-60 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}}"
    >
        <div
            class="w-11 h-6 rounded-full p-0.5 transition-colors duration-200 ease-in-out relative"
            :class="isActive ? 'bg-primary-500 dark:bg-primary-400' : 'bg-neutral-300 dark:bg-neutral-700'"
        >
            <div
                class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 ease-in-out"
                :class="isActive ? 'translate-x-5' : 'translate-x-0'"
            ></div>
        </div>

        @if($label || $slot->isNotEmpty())
            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors leading-none">
                {{ $label ?? $slot }}
            </span>
        @endif
    </label>
</div>
