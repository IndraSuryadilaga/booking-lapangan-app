<span {{ $attributes->merge(['class' => 'inline-block ' . $colorClass]) }}>
    {{-- Inject the SVG content and ensure it fills its parent --}}
    @php
        $svgContent = file_get_contents(public_path('images/logo-web/logo.svg'));
        echo str_replace('<svg', '<svg class="w-full h-full"', $svgContent);
    @endphp
</span>
