@props(['review'])

<div class="border rounded-lg p-4 bg-white">
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-sm font-medium text-neutral-700">{{ strtoupper(substr($review->user->name ?? 'U',0,1)) }}</div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div class="font-semibold text-sm">{{ $review->user->name ?? 'Pengguna' }}</div>
                <div class="text-sm text-neutral-500">{{ $review->created_at->format('d M Y') }}</div>
            </div>
            <div class="mt-1 flex items-center">
                <x-star-rating :value="$review->rating ?? 0" size="sm" />
            </div>
            <p class="text-sm text-neutral-700 mt-2">{{ $review->comment }}</p>
        </div>
    </div>
</div>
