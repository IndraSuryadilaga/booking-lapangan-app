@props(["value" => 0, "size" => 'md'])

@php
    $value = (float) $value;
    $sizes = ['sm' => 'w-3 h-3', 'md' => 'w-4 h-4'];
    $svgClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="flex items-center" aria-hidden="true">
    @for($i = 1; $i <= 5; $i++)
        @php
            $fill = 'none';
            if ($value >= $i) {
                $fill = 'currentColor';
            } elseif ($value > $i - 1 && $value < $i) {
                $fill = "url(#half-{$i})";
            }
        @endphp
        <svg class="{{ $svgClass }} text-warning-400 mr-0.5" viewBox="0 0 24 24" fill="{{ $fill }}" stroke="currentColor" stroke-width="1">
            <defs>
                <linearGradient id="half-{{ $i }}" x1="0" x2="1">
                    <stop offset="50%" stop-color="currentColor" />
                    <stop offset="50%" stop-color="transparent" />
                </linearGradient>
            </defs>
            <path d="M12 .587l3.668 7.431L24 9.748l-6 5.848L19.335 24 12 20.201 4.665 24 6 15.596 0 9.748l8.332-1.73z" />
        </svg>
    @endfor
</div>
