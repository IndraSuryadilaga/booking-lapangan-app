<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:space-x-6">
            {{-- Filter sidebar --}}
            <aside class="md:w-72 mb-6 md:mb-0">
                <form method="GET" action="{{ route('venues.index') }}" class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-xl p-4">
                        <h3 class="font-semibold mb-3">Filter</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Kota</label>
                            <select name="city" class="w-full rounded-md border-gray-200">
                                <option value="">Semua Kota</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}" {{ request('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Kategori Olahraga</label>
                            <div class="space-y-2 max-h-48 overflow-auto pr-2">
                                @foreach($allCategories as $cat)
                                    <div class="flex items-center">
                                        <input id="cat-{{ $cat->id }}" name="category[]" value="{{ $cat->id }}" type="checkbox" class="h-4 w-4" {{ in_array($cat->id, (array) request('category', [])) ? 'checked' : '' }}>
                                        <label for="cat-{{ $cat->id }}" class="ml-2 text-sm">{{ $cat->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-400 text-white rounded-full">Terapkan</button>
                            <a href="{{ route('venues.index') }}" class="text-sm text-neutral-500">Reset</a>
                        </div>
                    </div>
                </form>
            </aside>

            {{-- Results --}}
            <div class="flex-1">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-extrabold">Katalog Venue</h1>
                    <div class="text-sm text-neutral-500">Menampilkan {{ $venues->total() }} hasil</div>
                </div>

                @if($venues->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl p-8 text-center">
                        <h3 class="text-xl font-semibold">Tidak ditemukan venue</h3>
                        <p class="text-sm text-neutral-500 mt-2">Coba ubah filter Anda atau hapus beberapa kriteria pencarian.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($venues as $venue)
                            <x-venue-card :venue="$venue" />
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $venues->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
