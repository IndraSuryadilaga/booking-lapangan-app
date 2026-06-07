<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Tambah Lapangan Baru</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Buat data lapangan baru, unggah foto, dan atur jam operasional serta tarif per slot.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.fields.index') }}">
                        <x-atoms.button type="secondary" class="px-4 py-2 text-sm">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl">
                    <strong class="text-sm font-semibold">Oops! Gagal menyimpan data:</strong>
                    <ul class="list-disc pl-5 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6">
                <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Venue & Kategori Olahraga -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Venue</label>
                            <x-atoms.select name="venue_id" placeholder="-- Pilih Venue --"
                                :options="$venues->map(fn($v) => ['value' => $v->id, 'label' => $v->name])->toArray()" required />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Kategori Olahraga</label>
                            <x-atoms.select name="sports_category_id" placeholder="-- Pilih Kategori --"
                                :options="$categories->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->toArray()" required />
                        </div>
                    </div>

                    <!-- Nama Lapangan -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Nama Lapangan</label>
                        <x-atoms.input type="text" name="name" placeholder="Contoh: Lapangan Futsal A" value="{{ old('name') }}" required />
                    </div>

                    <!-- Galeri Foto -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Galeri Foto Lapangan (Bisa Unggah Banyak)</label>
                        <x-atoms.input-file name="images" accept="image/*" :multiple="true" />
                        <p class="text-xs text-neutral-400 mt-2 font-medium">Foto pertama otomatis menjadi foto utama (primary).</p>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Deskripsi Singkat</label>
                        <x-atoms.input-textarea name="description" placeholder="Info fasilitas lapangan, ukuran, tipe rumput..." rows="3">{{ old('description') }}</x-atoms.input-textarea>
                    </div>

                    <!-- Tarif / Pricing Tiers -->
                    <div class="border-t border-neutral-100 pt-6">
                        <h2 class="text-base font-bold text-neutral-800 mb-4">Pengaturan Harga per Slot</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Regular Weekday -->
                            <div class="p-4 border border-neutral-200/60 rounded-2xl bg-neutral-50/50 space-y-3">
                                <input type="hidden" name="pricings[0][tier]" value="regular">
                                <span class="block font-bold text-neutral-400 uppercase tracking-wider text-xs">Regular (Weekday)</span>
                                <x-atoms.input-number name="pricings[0][price]" value="100000" min="0" prefix="Rp" :isCurrency="true" required />
                            </div>

                            <!-- Weekend -->
                            <div class="p-4 border border-neutral-200/60 rounded-2xl bg-neutral-50/50 space-y-3">
                                <input type="hidden" name="pricings[1][tier]" value="weekend">
                                <span class="block font-bold text-neutral-400 uppercase tracking-wider text-xs">Weekend (Sabtu-Minggu)</span>
                                <x-atoms.input-number name="pricings[1][price]" value="150000" min="0" prefix="Rp" :isCurrency="true" required />
                            </div>

                            <!-- Holiday -->
                            <div class="p-4 border border-neutral-200/60 rounded-2xl bg-neutral-50/50 space-y-3">
                                <input type="hidden" name="pricings[2][tier]" value="holiday">
                                <span class="block font-bold text-neutral-400 uppercase tracking-wider text-xs">Hari Libur Nasional</span>
                                <x-atoms.input-number name="pricings[2][price]" value="175000" min="0" prefix="Rp" :isCurrency="true" required />
                            </div>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="border-t border-neutral-100 pt-6">
                        <h2 class="text-base font-bold text-neutral-800 mb-4">Pengaturan Jam Operasional Mingguan</h2>

                        @php
                            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        @endphp

                        <div class="space-y-4">
                            @foreach($days as $index => $day)
                                <div x-data="{ isOpen: true }" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 border border-neutral-200/50 rounded-2xl bg-neutral-50/30">
                                    <div class="w-32 shrink-0">
                                        <label class="inline-flex items-center cursor-pointer select-none">
                                            <input type="hidden" name="operating_hours[{{ $index }}][is_open]" value="0">
                                            <input type="checkbox" name="operating_hours[{{ $index }}][is_open]" value="1" x-model="isOpen" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                                            <input type="hidden" name="operating_hours[{{ $index }}][day_of_week]" value="{{ $index }}">
                                            <span class="ml-2.5 font-bold text-neutral-700 text-sm">{{ $day }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-neutral-400 font-bold uppercase tracking-wider">Buka</span>
                                            <input type="time" name="operating_hours[{{ $index }}][open_time]" value="08:00" :disabled="!isOpen" class="border border-neutral-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 disabled:bg-neutral-100 disabled:text-neutral-400 shadow-sm font-semibold">
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-neutral-400 font-bold uppercase tracking-wider">Tutup</span>
                                            <input type="time" name="operating_hours[{{ $index }}][close_time]" value="22:00" :disabled="!isOpen" class="border border-neutral-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 disabled:bg-neutral-100 disabled:text-neutral-400 shadow-sm font-semibold">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-neutral-100">
                        <a href="{{ route('admin.fields.index') }}">
                            <x-atoms.button type="button" variant="secondary" class="px-5 py-2.5 text-sm">Batal</x-atoms.button>
                        </a>
                        <x-atoms.button type="primary" class="px-6 py-2.5 text-sm">
                            Simpan Lapangan
                        </x-atoms.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
