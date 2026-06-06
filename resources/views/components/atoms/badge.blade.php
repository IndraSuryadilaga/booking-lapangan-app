@props(['type' => 'default', 'name' => '', 'icon' => null])

@if($type === 'sport')
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-3 py-1.5 bg-primary-100 dark:bg-primary-900 text-sm font-medium text-primary-700 dark:text-primary-300 rounded-full border border-primary-200 dark:border-primary-800 shadow-2xs']) }}>
        @if($icon)
            @if(str_contains($icon, '<svg'))
                <span class="w-4 h-4 flex items-center justify-center shrink-0 text-primary-500 dark:text-primary-400">{!! $icon !!}</span>
            @else
                <span
                    class="w-4 h-4 bg-primary-500 dark:bg-primary-400 shrink-0"
                    style="
                        mask-image: url('{{ asset($icon) }}');
                        mask-size: contain;
                        mask-repeat: no-repeat;
                        mask-position: center;
                        -webkit-mask-image: url('{{ asset($icon) }}');
                        -webkit-mask-size: contain;
                        -webkit-mask-repeat: no-repeat;
                        -webkit-mask-position: center;
                    "
                    aria-hidden="true"
                ></span>
            @endif
        @else
            <svg class="w-4 h-4 text-primary-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
        @endif
        <span class="truncate">{{ $slot->isEmpty() ? $name : $slot }}</span>
    </span>
@elseif($type === 'facility')
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-3 py-1.5 bg-neutral-50 dark:bg-neutral-900 text-sm font-medium text-neutral-700 dark:text-neutral-300 rounded-full border border-slate-100 dark:border-neutral-700 shadow-2xs']) }}>
        @if($icon)
            @if(str_contains($icon, '<svg'))
                <span class="w-4 h-4 flex items-center justify-center shrink-0 text-neutral-500 dark:text-neutral-400">{!! $icon !!}</span>
            @else
                {{-- Jika isi DB adalah Path File (Gunakan CSS Mask agar mengikuti warna text-neutral) --}}
                <span
                    class="w-4 h-4 bg-neutral-500 dark:bg-neutral-400 shrink-0"
                    style="
                        mask-image: url('{{ asset($icon) }}');
                        mask-size: contain;
                        mask-repeat: no-repeat;
                        mask-position: center;
                        -webkit-mask-image: url('{{ asset($icon) }}');
                        -webkit-mask-size: contain;
                        -webkit-mask-repeat: no-repeat;
                        -webkit-mask-position: center;
                    "
                    aria-hidden="true"
                ></span>
            @endif
        @else
            <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        @endif
        <span class="truncate">{{ $slot->isEmpty() ? $name : $slot }}</span>
    </span>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-full border border-gray-200 dark:border-gray-600 shadow-2xs']) }}>
        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="truncate">{{ $slot->isEmpty() ? $name : $slot }}</span>
    </span>
@endif
