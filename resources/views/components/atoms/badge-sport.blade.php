@props([
    'name' => '',
    'icon' => null,
])

<span class="inline-flex items-center gap-1.5 font-medium text-primary-500 dark:text-primary-100 bg-primary-100 dark:bg-primary-500/30 px-2.5 py-1 rounded-md text-12 shrink-0 whitespace-nowrap">

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
