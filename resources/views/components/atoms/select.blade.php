@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'value' => '',
    'placeholder' => 'Pilih opsi...',
    'options' => [],
    'error' => false,
    'errorMessage' => '',
    'messages' => [],
])

@php
    $id = $id ?? $name ?? uniqid('select-');

    $laravelErrors = $name && $errors->has($name) ? $errors->get($name) : [];

    $allErrors = [];
    if ($errorMessage) {
        $allErrors[] = $errorMessage;
    }
    if (!empty($messages)) {
        $allErrors = array_merge($allErrors, (array) $messages);
    }
    if (!empty($laravelErrors)) {
        $allErrors = array_merge($allErrors, $laravelErrors);
    }

    $hasError = $error || count($allErrors) > 0;

    $borderClass = $hasError
        ? 'border-danger-500 border focus:border-danger-500 focus:ring-1 focus:ring-danger-500 dark:border-danger-500'
        : 'border-neutral-300 border focus:border-primary-500 focus:ring-1 focus:ring-primary-500 dark:border-neutral-700 dark:focus:border-primary-400';
@endphp

<div class="w-full relative"
     x-data="{
        open: false,
        value: '{{ $value }}',
        options: {{ json_encode($options) }},

        // Mengambil teks label berdasarkan value yang terpilih
        get selectedLabel() {
            let selectedOption = this.options.find(opt => opt.value == this.value);
            return selectedOption ? selectedOption.label : '{{ $placeholder }}';
        },

        // Aksi saat item dipilih
        selectOption(val) {
            this.value = val;
            this.open = false;
        }
     }"
     @click.outside="open = false"
>
    <input type="hidden" name="{{ $name }}" :value="value" id="{{ $id }}">

    <button
        type="button"
        @click="if(!{{ $disabled ? 'true' : 'false' }}) open = !open"
        class="relative w-full text-left rounded-full shadow-sm bg-white dark:bg-neutral-900 transition-colors duration-200 sm:text-sm py-2 sm:py-[10px] pl-4 sm:pl-6 pr-10 {{ $borderClass }} cursor-pointer focus:outline-none"
        :class="{'opacity-75 cursor-not-allowed bg-neutral-100 dark:bg-neutral-800': {{ $disabled ? 'true' : 'false' }}}"
    >
        <span class="block truncate"
              :class="value === '' ? 'text-neutral-400 dark:text-neutral-500 font-bold' : 'text-neutral-900 dark:text-white'"
              x-text="selectedLabel">
        </span>

        <span class="absolute inset-y-0 right-0 pr-4 sm:pr-5 flex items-center pointer-events-none text-neutral-400">
            <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </span>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 w-full rounded-2xl bg-white dark:bg-neutral-800 shadow-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden py-1.5"
        style="display: none;"
    >
        <ul class="max-h-60 overflow-y-auto text-sm text-neutral-700 dark:text-neutral-300">
            <template x-for="option in options" :key="option.value">
                <li
                    @click="selectOption(option.value)"
                    class="px-4 py-2 mx-1.5 rounded-xl hover:bg-primary-50 dark:hover:bg-neutral-700 hover:text-primary-600 dark:hover:text-primary-400 cursor-pointer flex items-center justify-between transition-colors"
                    :class="value === option.value ? 'bg-primary-50 dark:bg-neutral-700/50 text-primary-600 dark:text-primary-400 font-medium' : ''"
                >
                    <span x-text="option.label"></span>

                    <svg x-show="value === option.value" class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </li>
            </template>
        </ul>
    </div>

    @if($hasError && count($allErrors) > 0)
        <ul class="mt-1.5 text-sm text-danger-500 font-medium space-y-1">
            @foreach ($allErrors as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    @endif
</div>
