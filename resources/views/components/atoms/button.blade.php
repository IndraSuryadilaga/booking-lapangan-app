@props([
    'type' => 'primary',
    'state' => 'default',
])

@php
    $baseClasses = 'inline-flex items-center justify-center px-6 py-2.5 rounded-full font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-neutral-900';

    $styles = [
        'primary' => [
            'default' => 'bg-primary-400 text-white hover:bg-primary-500 active:bg-primary-600 active:scale-95 disabled:bg-neutral-200 disabled:text-neutral-400 disabled:cursor-not-allowed disabled:scale-100 focus:ring-primary-400
                          dark:hover:bg-primary-300 dark:hover:shadow-[0_0_20px_var(--color-primary-400)] dark:active:bg-primary-500 dark:disabled:bg-neutral-600 dark:disabled:text-neutral-400 dark:disabled:shadow-none',

            'hover'   => 'bg-primary-500 text-white focus:ring-primary-400
                          dark:bg-primary-300 dark:shadow-[0_0_20px_var(--color-primary-400)]',

            'pressed' => 'bg-primary-600 text-white scale-95 focus:ring-primary-400
                          dark:bg-primary-500',

            'muted'   => 'bg-neutral-200 text-neutral-400 cursor-not-allowed
                          dark:bg-neutral-600 dark:text-neutral-400 dark:shadow-none',
        ],
        'outline' => [
            'default' => 'bg-transparent border-2 border-primary-400 text-primary-500 hover:bg-primary-100 active:bg-primary-200 active:scale-95 disabled:border-neutral-300 disabled:text-neutral-400 disabled:bg-transparent disabled:cursor-not-allowed disabled:scale-100 focus:ring-primary-400
                          dark:text-primary-300 dark:hover:bg-primary-700 dark:hover:text-white dark:active:bg-primary-600 dark:disabled:border-neutral-600 dark:disabled:text-neutral-500',

            'hover'   => 'bg-primary-100 border-2 border-primary-400 text-primary-500 focus:ring-primary-400
                          dark:bg-primary-700 dark:text-white',

            'pressed' => 'bg-primary-200 border-2 border-primary-400 text-primary-600 scale-95 focus:ring-primary-400
                          dark:bg-primary-600 dark:text-white',

            'muted'   => 'bg-transparent border-2 border-neutral-300 text-neutral-400 cursor-not-allowed
                          dark:border-neutral-600 dark:text-neutral-500',
        ],
        'destructive' => [
            'default' => 'bg-danger-400 text-white hover:bg-danger-500 active:bg-danger-600 active:scale-95 disabled:bg-danger-100 disabled:text-danger-300 disabled:cursor-not-allowed disabled:scale-100 focus:ring-danger-400
                          dark:bg-danger-500 dark:hover:bg-danger-400 dark:hover:shadow-[0_0_20px_var(--color-danger-500)] dark:active:bg-danger-600 dark:disabled:bg-danger-700 dark:disabled:text-danger-300',

            'hover'   => 'bg-danger-500 text-white focus:ring-danger-400
                          dark:bg-danger-400 dark:shadow-[0_0_20px_var(--color-danger-500)]',

            'pressed' => 'bg-danger-600 text-white scale-95 focus:ring-danger-400
                          dark:bg-danger-600',

            'muted'   => 'bg-danger-100 text-danger-300 cursor-not-allowed
                          dark:bg-danger-700 dark:text-danger-300 dark:shadow-none',
        ],
        'warning' => [
            'default' => 'bg-warning-400 text-white hover:bg-warning-500 active:bg-warning-600 active:scale-95 disabled:bg-warning-100 disabled:text-warning-300 disabled:cursor-not-allowed disabled:scale-100 focus:ring-warning-400
                          dark:bg-warning-500 dark:hover:bg-warning-400 dark:hover:shadow-[0_0_20px_var(--color-warning-500)] dark:active:bg-warning-600 dark:disabled:bg-warning-700 dark:disabled:text-warning-300',

            'hover'   => 'bg-warning-500 text-white focus:ring-warning-400
                          dark:bg-warning-400 dark:shadow-[0_0_20px_var(--color-warning-500)]',

            'pressed' => 'bg-warning-600 text-white scale-95 focus:ring-warning-400
                          dark:bg-warning-600',

            'muted'   => 'bg-warning-100 text-warning-300 cursor-not-allowed
                          dark:bg-warning-700 dark:text-warning-300 dark:shadow-none',
        ],
        'text' => [
            'default' => 'bg-transparent text-primary-500 hover:bg-primary-100 active:bg-primary-200 active:scale-95 disabled:text-neutral-400 disabled:bg-transparent disabled:cursor-not-allowed disabled:scale-100 focus:ring-primary-400
                          dark:text-primary-400 dark:hover:bg-neutral-700 dark:hover:text-primary-300 dark:active:bg-neutral-600 dark:active:text-white dark:disabled:text-neutral-600',

            'hover'   => 'bg-primary-100 text-primary-600 focus:ring-primary-400
                          dark:bg-neutral-700 dark:text-primary-300',

            'pressed' => 'bg-primary-200 text-primary-700 scale-95 focus:ring-primary-400
                          dark:bg-neutral-600 dark:text-white',

            'muted'   => 'bg-transparent text-neutral-400 cursor-not-allowed
                          dark:text-neutral-600',
        ],
    ];

    $appliedClass = $styles[$type][$state] ?? $styles['primary']['default'];
    $isDisabled = $state === 'muted' || $attributes->has('disabled');
@endphp

<button
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $appliedClass]) }}
    {{ $isDisabled ? 'disabled' : '' }}
>
    {{ $slot }}
</button>
