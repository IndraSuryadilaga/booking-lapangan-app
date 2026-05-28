@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => '',
    'placeholder' => '',
    'variant' => 'default', // 'default' (untuk prefix/suffix) atau 'stepper' (untuk +/-)
    'prefix' => null,       // cth: 'Rp'
    'suffix' => null,       // cth: '/ Sesi'
    'isCurrency' => false,
    'min' => 0,
    'max' => null,
    'step' => 1,
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('number-');

    // Logika warna border jika ada error
    $borderClass = $error
        ? 'border-danger-500 focus:border-danger-500 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full">

    @if($variant === 'default')
        <div class="flex shadow-sm rounded-full w-full"
             @if($isCurrency)
                 x-data="{
                    rawValue: '{{ $value }}',
                    formattedValue: '',
                    init() {
                        this.formattedValue = this.formatNumber(this.rawValue);
                    },
                    formatNumber(val) {
                        if (!val) return '';
                        // Hapus semua karakter selain angka
                        let num = val.toString().replace(/[^0-9]/g, '');
                        // Gunakan format standar Indonesia (titik sebagai pemisah ribuan)
                        return new Intl.NumberFormat('id-ID').format(num);
                    },
                    handleInput(e) {
                        // Ambil nilai asli tanpa titik
                        let raw = e.target.value.replace(/[^0-9]/g, '');
                        this.rawValue = raw;
                        // Tampilkan kembali ke layar dengan format titik
                        this.formattedValue = this.formatNumber(raw);
                    }
                }"
            @endif
        >

            @if($prefix)
                <span class="inline-flex items-center px-4 rounded-l-full border border-r-0 border-neutral-300 bg-neutral-100 text-neutral-600 font-semibold sm:text-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    {{ $prefix }}
                </span>
            @endif

            @if($isCurrency)
                <input type="hidden" name="{{ $name }}" :value="rawValue">
            @endif

            <input
                type="{{ $isCurrency ? 'text' : 'number' }}"

                @if($isCurrency)
                    id="{{ $id }}"
                x-model="formattedValue"
                @input="handleInput($event)"
                @else
                    name="{{ $name }}"
                id="{{ $id }}"
                value="{{ $value }}"
                @endif

                placeholder="{{ $placeholder }}"
                min="{{ $min }}"
                {{ $max ? "max={$max}" : '' }}
                step="{{ $step }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge([
                    'class' => "flex-1 block w-full min-w-0 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white transition-colors duration-200 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-500 dark:disabled:bg-neutral-800 py-2 sm:py-[10px] $borderClass " .
                    ($prefix ? 'rounded-none' : 'rounded-l-full') . " " .
                    ($suffix ? 'rounded-none' : 'rounded-r-full') . " " .
                    "[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                ]) }}
            >

            @if($suffix)
                <span class="inline-flex items-center px-4 rounded-r-full border border-l-0 border-neutral-300 bg-neutral-100 text-neutral-600 font-semibold sm:text-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    {{ $suffix }}
                </span>
            @endif
        </div>

    @elseif($variant === 'stepper')
        <div x-data="{
                value: {{ $value !== '' ? $value : $min }},
                min: {{ $min }},
                max: {{ $max ?? 'null' }},
                step: {{ $step }},
                increment() {
                    if(this.max === null || this.value < this.max) {
                        this.value += this.step;
                    }
                },
                decrement() {
                    if(this.value > this.min) {
                        this.value -= this.step;
                    }
                }
            }"
             class="inline-flex items-center shadow-sm rounded-full border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 overflow-hidden w-fit"
        >
            <button
                type="button"
                @click="decrement"
                :disabled="value <= min"
                class="px-4 py-2 sm:py-[10px] text-neutral-500 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-neutral-800 disabled:opacity-50 disabled:hover:bg-transparent disabled:hover:text-neutral-500 transition-colors focus:outline-none"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
            </button>

            <input
                type="number"
                name="{{ $name }}"
                id="{{ $id }}"
                x-model.number="value"
                min="{{ $min }}"
                {{ $max ? "max={$max}" : '' }}
                {{ $disabled ? 'disabled' : '' }}
                class="w-8 text-center border-none bg-transparent focus:ring-0 text-neutral-900 dark:text-white font-bold sm:text-sm p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
            >

            <button
                type="button"
                @click="increment"
                :disabled="max !== null && value >= max"
                class="px-4 py-2 sm:py-[10px] text-neutral-500 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-neutral-800 disabled:opacity-50 disabled:hover:bg-transparent disabled:hover:text-neutral-500 transition-colors focus:outline-none"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
    @endif

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
