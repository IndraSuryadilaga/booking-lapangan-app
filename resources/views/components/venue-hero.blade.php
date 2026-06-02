@props(['venue', 'images' => []])

@php
    // Build safe image list: venue logo first, then field primary images (controller sets primary_image_url)
    $imageList = collect();
    if (!empty($venue->logo_url)) {
        $imageList->push($venue->logo_url);
    }
    if ($venue->relationLoaded('fields')) {
        $venue->fields->each(function ($f) use ($imageList) {
            if (!empty($f->primary_image_url)) {
                $imageList->push($f->primary_image_url);
            }
        });
    }
    // Fallback placeholder if no images
    if ($imageList->isEmpty()) {
        $imageList->push('https://via.placeholder.com/1200x600');
    }

    $rating = $venue->rating_avg ?? null;
    $location = trim(($venue->city ?? '') . ' ' . ($venue->province ?? ''));

    // Compute starting price from fields (controller attaches weekday_price)
    $minPrice = null;
    if ($venue->relationLoaded('fields')) {
        $prices = $venue->fields->pluck('weekday_price')->filter(function ($v) { return !is_null($v); });
        if ($prices->isNotEmpty()) {
            $minPrice = $prices->min();
        }
    }
@endphp

<div class="bg-gradient-to-r from-gray-900 via-blue-950 to-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2">
                <div class="rounded-xl overflow-hidden relative">
                    <div class="relative w-full h-72 overflow-hidden">
                        @foreach($imageList as $idx => $img)
                            <img src="{{ $img }}" alt="{{ $venue->name }} - {{ $idx + 1 }}" class="carousel-item absolute inset-0 w-full h-72 object-cover transition-opacity duration-300 {{ $idx === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $idx }}">
                        @endforeach

                        <button type="button" class="carousel-prev absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 text-neutral-800 rounded-full p-2 shadow-sm">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button type="button" class="carousel-next absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 text-neutral-800 rounded-full p-2 shadow-sm">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <div class="mt-2 flex items-center justify-center gap-2">
                        @foreach($imageList as $idx => $img)
                            <button type="button" class="carousel-dot w-2 h-2 rounded-full {{ $idx === 0 ? 'bg-white' : 'bg-white/50' }}" data-index="{{ $idx }}" aria-label="Pilih gambar {{ $idx + 1 }}"></button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 text-white">
                    <h1 class="text-3xl font-extrabold">{{ $venue->name }}</h1>
                    <div class="flex items-center gap-4 mt-2">
                        @if($rating)
                            <div class="flex items-center gap-2">
                                <x-star-rating :value="$rating" size="sm" />
                                <span class="font-semibold">{{ $rating }}</span>
                            </div>
                        @endif

                        <div class="text-sm text-white/80">{{ $venue->review_count ?? 0 }} ulasan</div>
                    </div>
                </div>
            </div>

            {{-- Quick info panel --}}
            <aside class="bg-white rounded-xl p-6 shadow-sm">
                <div class="text-sm text-neutral-600 mb-3">Alamat</div>
                <div class="font-medium">{{ $venue->address ?? '-' }}</div>
                <div class="text-sm text-neutral-500 mt-1">{{ $location }}</div>

                <div class="mt-6 border-t pt-4">
                    <div class="text-sm text-neutral-600">Fasilitas</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($venue->facilities as $facility)
                            <x-facility-badge :name="$facility->name" />
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    @if(!is_null($minPrice))
                        <div class="text-sm text-neutral-600 mb-2">Harga mulai dari</div>
                        <div class="text-lg font-bold mb-3">Rp {{ number_format($minPrice, 0, ',', '.') }}</div>
                    @endif

                    <button onclick="event.preventDefault(); const el=document.getElementById('fields-list'); if(el) el.scrollIntoView({behavior:'smooth'});" class="mt-2 w-full inline-flex items-center justify-center px-4 py-2 rounded-lg bg-primary-500 text-white font-semibold">Cek Ketersediaan</button>
                </div>
            </aside>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const items = Array.from(document.querySelectorAll('.carousel-item'));
            if (!items.length) return;
            let index = 0;
            const show = (i) => {
                items.forEach((el) => el.classList.add('opacity-0'));
                items.forEach((el) => el.classList.remove('opacity-100'));
                const active = items[i];
                if (active) {
                    active.classList.remove('opacity-0');
                    active.classList.add('opacity-100');
                }
                document.querySelectorAll('.carousel-dot').forEach(d => d.classList.remove('bg-white'));
                const dot = document.querySelector('.carousel-dot[data-index="' + i + '"]');
                if (dot) dot.classList.add('bg-white');
            };

            document.querySelectorAll('.carousel-next').forEach(btn => btn.addEventListener('click', () => {
                index = (index + 1) % items.length;
                show(index);
            }));
            document.querySelectorAll('.carousel-prev').forEach(btn => btn.addEventListener('click', () => {
                index = (index - 1 + items.length) % items.length;
                show(index);
            }));
            document.querySelectorAll('.carousel-dot').forEach(d => d.addEventListener('click', (e) => {
                const i = parseInt(e.currentTarget.getAttribute('data-index')) || 0;
                index = i;
                show(index);
            }));
        });
    </script>
@endpush
