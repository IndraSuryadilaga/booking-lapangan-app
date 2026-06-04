@props([
    'type' => 'status',
    'variant' => 'success',
    'name' => '',
    'icon' => null,
])

@if($type === 'sport')
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-medium text-primary-500 dark:text-primary-100 bg-primary-100 dark:bg-primary-500/30 px-2.5 py-1 rounded-md text-12 shrink-0 whitespace-nowrap']) }}>
        @if($icon)
            <span
                class="w-3.5 h-3.5 bg-current shrink-0"
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

        <span>{{ $slot->isEmpty() ? $name : $slot }}</span>
    </span>
@elseif($type === 'facility')
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-3 py-1 bg-neutral-50 text-sm text-neutral-700 rounded-full border border-slate-100']) }}>
        @if($icon)
            <span class="w-4 h-4 flex items-center justify-center text-neutral-500">{!! $icon !!}</span>
        @else
            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        @endif
        <span class="truncate">{{ $slot->isEmpty() ? $name : $slot }}</span>
    </span>
@else
    @php
        $classes = [
            'success' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'danger' => 'bg-rose-100 text-rose-700 border-rose-200',
            'warning' => 'bg-amber-100 text-amber-700 border-amber-200',
            'info' => 'bg-blue-100 text-blue-700 border-blue-200',
        ][$variant] ?? 'bg-blue-100 text-blue-700 border-blue-200';
    @endphp

    <span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border $classes"]) }}>
        {{ $slot }}
    </span>
@endif
