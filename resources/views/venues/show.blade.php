<x-app-layout>
    {{-- Hero --}}
    <x-venue-hero :venue="$venue" />

    {{-- Main content: Info, Fields, Reviews --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            {{-- Info --}}
            <section class="bg-white border border-slate-200 rounded-xl p-6">
                <h2 class="text-xl font-bold mb-4">Informasi</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <h3 class="text-sm text-neutral-500">Deskripsi</h3>
                        <p class="mt-1 text-neutral-700">{{ $venue->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm text-neutral-500">Kebijakan Refund</h3>
                        <p class="mt-1 text-neutral-700">{{ $venue->refund_policy ?? 'Tidak ada informasi.' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm text-neutral-500">Kebijakan Reschedule</h3>
                        <p class="mt-1 text-neutral-700">{{ $venue->reschedule_policy ?? 'Tidak ada informasi.' }}</p>
                    </div>
                </div>
            </section>

            {{-- Fields --}}
            <section id="fields-list" class="bg-white border border-slate-200 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">Lapangan di {{ $venue->name }}</h2>
                    <div class="text-sm text-neutral-500">{{ $venue->fields->count() }} lapangan</div>
                </div>

                @if($venue->fields->isEmpty())
                    <div class="text-center text-neutral-500 py-6">Belum ada lapangan terdaftar untuk venue ini.</div>
                @else
                    @php
                        $totalFields = $venue->fields->count();
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" id="fields-grid">
                        @foreach($venue->fields as $field)
                            @php
                                $image = $field->primary_image_url ?? 'https://via.placeholder.com/800x600';
                                $sport = optional($field->sportsCategory)->name ?? 'Lainnya';
                            @endphp

                            <div class="{{ $loop->index >= 3 ? 'hidden more-field' : '' }}">
                                <a href="{{ route('fields.show', $field->slug) }}">
                                    <x-molecules.cards.court
                                        :image="$image"
                                        :name="$field->name"
                                        :description="$field->description"
                                        :sport="$sport"
                                        :type="$field->type"
                                        :material="$field->surface_material"
                                        :schedules="$field->schedules"
                                    />
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if($totalFields > 3)
                        <div class="mt-4 text-center">
                            <button id="show-more-fields" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg font-semibold">Lihat Selengkapnya</button>
                        </div>
                    @endif
                @endif
            </section>

            {{-- Reviews --}}
            <section class="bg-white border border-slate-200 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">Ulasan Terbaru</h2>
                    <div class="text-sm text-neutral-500">Menampilkan 5 ulasan terbaru</div>
                </div>

                @php
                    $recentReviews = $venue->reviews->sortByDesc('created_at')->take(5);
                @endphp

                @if($recentReviews->isEmpty())
                    <div class="text-center text-neutral-500 py-6">Belum ada ulasan untuk venue ini.</div>
                @else
                    <div class="space-y-4">
                        @foreach($recentReviews as $review)
                            <x-review-card :review="$review" />
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Sidebar: additional venue summary --}}
        <aside class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-xl p-6 text-center">
                <div class="text-xs text-neutral-500">Rating Rata-rata</div>
                <div class="text-3xl font-extrabold">{{ $venue->rating_avg ?? '-' }}</div>
                <div class="text-sm text-neutral-500">dari {{ $venue->review_count ?? 0 }} ulasan</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-6">
                <h3 class="font-semibold mb-2">Kategori Olahraga</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($venue->sportsCategories as $cat)
                        <span class="px-2 py-1 bg-neutral-50 rounded-full text-sm">{{ $cat->name }}</span>
                    @empty
                        <div class="text-sm text-neutral-500">Tidak ada kategori.</div>
                    @endforelse
                </div>
            </div>

            {{-- Map placeholder --}}
            <div class="bg-white border border-slate-200 rounded-xl p-6">
                <h3 class="font-semibold mb-2">Lokasi</h3>
                @if($venue->latitude && $venue->longitude)
                    <iframe class="w-full h-44 rounded-md" frameborder="0" loading="lazy" src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"></iframe>
                @else
                    <div class="w-full h-44 rounded-md bg-neutral-100 flex items-center justify-center text-neutral-500">Peta tidak tersedia</div>
                @endif
            </div>
        </aside>
    </div>

    {{-- Recommendations --}}
    @if(!empty($recommendations) && $recommendations->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold">Rekomendasi Venue Lainnya</h2>
                <div class="text-sm text-neutral-500">Mungkin Anda juga tertarik</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendations as $rec)
                    <x-venue-card :venue="$rec" />
                @endforeach
            </div>
        </section>
    @endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('show-more-fields');
            if (!btn) return;
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.more-field').forEach(function (el) {
                    el.classList.remove('hidden');
                });
                btn.style.display = 'none';
            });
        });
    </script>
@endpush
</x-app-layout>
