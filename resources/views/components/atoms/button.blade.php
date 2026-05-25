@php
    $baseClasses = 'inline-flex items-center justify-center px-6 py-2.5 rounded-full font-semibold transition-all duration-200 focus:outline-none';

    $styles = [
        'primary'   => 'bg-primary-400 text-white
                        hover:bg-primary-500
                        active:bg-primary-600 active:scale-95
                        disabled:bg-neutral-200 disabled:text-neutral-400 disabled:cursor-not-allowed disabled:scale-100
                        focus-visible:ring-2 focus-visible:ring-primary-500
                        dark:text-primary-500 dark:bg-white
                        dark:hover:bg-primary-100
                        dark:hover:shadow-[0_0_20px_var(--color-primary-400)]
                        dark:active:bg-primary-500
                        dark:disabled:bg-neutral-600 dark:disabled:text-neutral-400',

        'secondary' => 'bg-primary-100 border-2 border-primary-500 text-primary-500
                        hover:bg-primary-200
                        active:bg-primary-300 active:scale-95
                        disabled:border-neutral-300 disabled:text-neutral-400 disabled:bg-transparent disabled:cursor-not-allowed disabled:scale-100
                        dark:bg-primary-300 dark:border-2 dark:border-white dark:text-white
                        dark:hover:bg-primary-400 dark:hover:text-white
                        dark:active:bg-primary-600
                        dark:disabled:border-neutral-600 dark:disabled:text-neutral-500',

        'danger'    => 'bg-danger-400 text-white
                        hover:bg-danger-500
                        active:bg-danger-600 active:scale-95
                        disabled:bg-danger-100 disabled:text-danger-300 disabled:cursor-not-allowed disabled:scale-100',

        'warning'   => 'bg-warning-400 text-white
                        hover:bg-warning-500
                        active:bg-warning-600 active:scale-95
                        disabled:bg-warning-100 disabled:text-warning-300 disabled:cursor-not-allowed disabled:scale-100',

        'text'      => 'bg-transparent text-primary-500
                        hover:bg-primary-100
                        active:bg-primary-200 active:scale-95
                        disabled:text-neutral-400 disabled:bg-transparent disabled:cursor-not-allowed disabled:scale-100
                        dark:text-primary-400
                        dark:hover:bg-neutral-700 dark:hover:text-primary-300
                        dark:active:bg-neutral-600 dark:active:text-white
                        dark:disabled:text-neutral-600',
    ];

    $appliedClass = $styles[$type] ?? $styles['primary'];
    $isDisabled = $attributes->has('disabled') && $attributes->get('disabled') !== false;
@endphp

<button
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $appliedClass]) }}
    {{ $isDisabled ? 'disabled' : '' }}
>
    {{ $slot }}
</button>
