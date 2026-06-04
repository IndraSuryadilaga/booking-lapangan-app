<x-app-layout>
    @php
        $cityOptions = [['value' => '', 'label' => 'Pilih Kota']];
        foreach ($cities as $c) {
            $cityOptions[] = ['value' => $c, 'label' => $c];
        }

        $categoryOptions = [['value' => '', 'label' => 'Badminton']];
        foreach ($allCategories as $cat) {
            $categoryOptions[] = ['value' => $cat->id, 'label' => $cat->name];
        }

        $selectedCategory = '';
        if (request()->has('category')) {
            $catInput = request('category');
            if (is_array($catInput)) {
                $selectedCategory = head($catInput);
            } else {
                $selectedCategory = $catInput;
            }
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        {{-- 1. Section Penawaran Pendaftaran Venue Sederhana --}}
        <div class="mb-8 bg-slate-900 border border-slate-800 text-white rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-3">
                        Kemitraan Venue
                    </span>
                    <h2 class="text-xl md:text-2xl font-extrabold tracking-tight text-white">Punya Lapangan Olahraga?</h2>
                    <p class="text-sm text-neutral-300 mt-2">
                        Daftarkan venue Anda sekarang untuk meraih lebih banyak pelanggan, kelola jadwal operasional, set tarif dinamis, dan terima pembayaran aman melalui dashboard terintegrasi.
                    </p>
                </div>
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.venues.create') }}" class="w-full md:w-auto">
                        <x-atoms.button type="primary" class="w-full md:w-auto px-6 py-2.5 font-bold shadow-md hover:shadow-lg transition-all">
                            Daftarkan Venue Anda
                        </x-atoms.button>
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Section Filter Pencarian Horizontal --}}
        <div class="mb-8 bg-white border border-slate-200 rounded-3xl p-5 md:p-6 shadow-md max-w-7xl mx-auto">
            <form method="GET" action="{{ route('venues.index') }}">
                <div class="flex flex-col lg:flex-row gap-4 items-center w-full">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-grow w-full">
                        <!-- Kolom 1: Pencarian Nama Venue -->
                        <x-atoms.input
                            type="search"
                            name="search"
                            placeholder="Cari nama venue"
                            value="{{ request('search') }}"
                        />

                        <!-- Kolom 2: Pilihan Kota (select-searchable) -->
                        <div class="relative w-full [&_button]:pl-10 sm:[&_button]:pl-11">
                            <span class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none text-neutral-400 z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <x-atoms.select-searchable
                                name="city"
                                placeholder="Pilih Kota"
                                :options="$cities"
                                value="{{ request('city') }}"
                            />
                        </div>

                        <!-- Kolom 3: Pilihan Kategori (select) -->
                        <x-atoms.select
                            name="category[]"
                            placeholder="Pilih Kategori"
                            :options="$categoryOptions"
                            value="{{ $selectedCategory }}"
                        >
                            <x-slot name="iconLeft">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            </x-slot>
                        </x-atoms.select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3 w-full lg:w-auto shrink-0 justify-end mt-4 lg:mt-0">
                        <a href="{{ route('venues.index') }}" class="text-sm font-semibold text-neutral-500 hover:text-neutral-800 px-4 py-2.5 transition-colors rounded-full text-center">
                            Reset
                        </a>
                        <x-atoms.button type="primary" class="w-full lg:w-auto px-8 py-2.5 font-bold shadow-md hover:shadow-lg transition-all rounded-full">
                            Cari
                        </x-atoms.button>
                    </div>
                </div>
            </form>
        </div>

        {{-- 3. Results: Venue Cards + Pagination --}}
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-extrabold">Katalog Venue</h1>
            <div class="text-sm text-neutral-500">Menampilkan {{ $venues->total() }} hasil</div>
        </div>

        @if($venues->isEmpty())
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center shadow-sm">
                <h3 class="text-xl font-semibold">Tidak ditemukan venue</h3>
                <p class="text-sm text-neutral-500 mt-2">Coba ubah filter Anda atau hapus beberapa kriteria pencarian.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($venues as $venue)
                    <x-molecules.cards.venue-card :venue="$venue" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $venues->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
