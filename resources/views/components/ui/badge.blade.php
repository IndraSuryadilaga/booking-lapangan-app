@props(['variant' => 'success'])

@php
    $classes = [
        'success' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'danger' => 'bg-rose-100 text-rose-700 border-rose-200',
        'warning' => 'bg-amber-100 text-amber-700 border-amber-200',
        'info' => 'bg-blue-100 text-blue-700 border-blue-200',
    ][$variant] ?? $classes['info'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border $classes"]) }}>
    {{ $slot }}
</span>
