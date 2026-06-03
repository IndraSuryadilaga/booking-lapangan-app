@props([
    'name' => 'slots',
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'error' => false,
    'errorMessage' => '',
])

@php
    $defaultSelected = $multiple
        ? json_encode(is_array($selected) ? $selected : [])
        : "'" . ($selected ?? '') . "'";
@endphp

<div class="w-full"
     x-data="{
        multiple: {{ $multiple ? 'true' : 'false' }},
        selected: {{ $defaultSelected }},
        name: '{{ $name }}',
        toggle(value, isDisabled) {
            if (isDisabled) return;
            if (this.multiple) {
                let index = this.selected.indexOf(value);
                if (index > -1) {
                    this.selected.splice(index, 1); // Hapus jika sudah ada
                } else {
                    this.selected.push(value); // Tambah jika belum ada
                }
            } else {
                this.selected = this.selected === value ? '' : value;
            }
        },
        isSelected(value) {
            return this.multiple
                ? this.selected.includes(value)
                : this.selected === value;
        }
    }"
>
    <template x-if="!multiple && selected !== ''">
        <input type="hidden" :name="name" :value="selected">
    </template>
    <template x-if="multiple">
        <template x-for="item in selected" :key="item">
            <input type="hidden" :name="name + '[]'" :value="item">
        </template>
    </template>

    <div class="flex flex-wrap gap-3">
        @foreach($options as $slot)
            @php
                $val = $slot['value'];
                $isDisabled = $slot['disabled'] ?? false;
            @endphp

            <button
                type="button"
                @click="toggle('{{ $val }}', {{ $isDisabled ? 'true' : 'false' }})"
                class="relative flex flex-col items-center justify-center px-4 py-2.5 rounded-xl border transition-all duration-200 min-w-[80px]"
                :class="{
                    // State: Terpilih
                    'bg-primary-500 border-primary-500 text-white shadow-md': isSelected('{{ $val }}') && !{{ $isDisabled ? 'true' : 'false' }},

                    // State: Tersedia & Belum Terpilih
                    'bg-white dark:bg-neutral-800 border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:border-primary-400 hover:text-primary-500 dark:hover:border-primary-400': !isSelected('{{ $val }}') && !{{ $isDisabled ? 'true' : 'false' }},

                    // State: Disabled / Penuh (Booked)
                    'bg-neutral-100 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 text-neutral-400 dark:text-neutral-600 cursor-not-allowed opacity-75': {{ $isDisabled ? 'true' : 'false' }}
                }"
            >
                {{-- PERUBAHAN: Membungkus setiap bagian dalam span dengan kelasnya sendiri --}}
                <span class="text-[10px] font-medium -mb-0.5"
                      :class="isSelected('{{ $val }}') ? 'text-white/75' : 'text-neutral-400 dark:text-neutral-500'">
                      {{ $slot['top_label'] ?? '' }}
                </span>
                <span class="font-bold text-sm sm:text-base">
                    {{ $slot['label'] }}
                </span>
                <span class="text-[10px] sm:text-xs font-medium mt-0.5"
                      :class="isSelected('{{ $val }}') ? 'text-primary-100' : 'text-emerald-600 dark:text-emerald-400'">
                      {{ $slot['bottom_label'] ?? '' }}
                </span>
            </button>
        @endforeach
    </div>

    @if($error && $errorMessage)
        <p class="mt-2 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
