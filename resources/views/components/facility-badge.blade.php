@props(['icon' => null, 'name'])

<span class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-50 text-sm text-neutral-700 rounded-full border border-slate-100">
    @if($icon)
        <span class="w-4 h-4 flex items-center justify-center text-neutral-500">{!! $icon !!}</span>
    @else
        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    @endif
    <span class="truncate">{{ $name }}</span>
</span>
