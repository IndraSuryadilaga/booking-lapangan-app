@props(['variant' => 'primary'])

@php
    $classes = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800',
        'secondary' => 'bg-gray-900 text-white hover:bg-gray-800',
        'outline' => 'border-2 border-primary-600 text-primary-600 hover:bg-primary-50',
    ][$variant];
@endphp

<button {{ $attributes->merge(['class' => "px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 transform active:scale-95 $classes"]) }}>
    {{ $slot }}
</button>
