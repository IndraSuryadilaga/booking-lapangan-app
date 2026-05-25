<span {{ $attributes->merge(['class' => 'inline-block ' . $colorClass]) }}>
    {{-- Inject the SVG content and ensure it fills its parent --}}
    @php
        echo str_replace('<svg', '<svg class="w-full h-full"', $svgContent);
    @endphp
</span>
