@props([
    'disabled' => false,
    'type' => 'text',
    'name' => '',
    'id' => null,
    'value' => '',
    'placeholder' => '',
    'iconLeft' => null,
    'isSearch' => false, // Boolean khusus untuk Search
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('input-');
    $isPassword = $type === 'password';
    $isSearchMode = $type === 'search' || $isSearch;

    // Responsive padding logic
    // Base padding (no icon) for small screens and up
    $paddingLeft = 'pl-4 sm:pl-6';
    $paddingRight = 'pr-4 sm:pr-6';

    // Override for left icon
    if ($iconLeft || $isSearchMode) {
        // Increase left padding to make space for the icon
        $paddingLeft = 'pl-10 sm:pl-12';
    }

    // Override for right icon (password toggle, search clear)
    if ($isPassword || $isSearchMode) {
        // Increase right padding to make space for the icon/button
        $paddingRight = 'pr-10 sm:pr-12';
    }

    // Logika warna border jika ada error
    $borderClass = $error
        ? 'border-danger-500 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full">
    <div x-data="{
            showPassword: false,
            hasValue: '{{ $value }}'.length > 0,
            clearSearch() {
                this.$refs.inputField.value = '';
                this.hasValue = false;
                this.$refs.inputField.focus();
            }
        }"
         class="relative flex items-center w-full"
    >

        @if($iconLeft || $isSearchMode)
            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none text-neutral-400 dark:text-neutral-500">
                @if($iconLeft)
                    {!! $iconLeft !!}
                @elseif($isSearchMode)
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                @endif
            </div>
        @endif

        <input
            x-ref="inputField"
            @input="hasValue = $event.target.value.length > 0"
            {{ $attributes->merge([
                'class' => "w-full rounded-full shadow-sm bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-2 sm:py-[10px] $paddingLeft $paddingRight $borderClass"
            ]) }}
            :type="showPassword ? 'text' : '{{ $type }}'"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $disabled ? 'disabled' : '' }}
        >

        @if($isPassword)
            <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 focus:outline-none transition-colors"
                tabindex="-1"
            >
                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0l-3.29-3.29"></path></svg>
                <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </button>
        @endif

        @if($isSearchMode)
            <button
                type="button"
                x-show="hasValue"
                @click="clearSearch()"
                class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center text-neutral-400 hover:text-danger-500 focus:outline-none transition-colors"
                style="display: none;"
            >
                <svg class="w-4 h-4 bg-neutral-200 dark:bg-neutral-700 rounded-full p-0.5 text-neutral-600 dark:text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        @endif
    </div>

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
