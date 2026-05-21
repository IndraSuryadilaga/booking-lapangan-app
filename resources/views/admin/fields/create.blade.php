<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Tambah Lapangan Baru</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
            {{-- Atribut enctype sangat penting agar foto bisa terkirim ke Controller --}}
            <form action="{{ route('fields.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Oops! Gagal menyimpan data:</strong>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Kategori Olahraga</label>
                    <select name="sports_category_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2 font-medium">Nama Lapangan</label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2" placeholder="Contoh: Lapangan Futsal Utama" required>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">Harga per Slot (Rp)</label>
                        <input type="number" name="price_per_slot" min="0" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Foto Lapangan Maks : 10MB</label>
                    <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-medium">Deskripsi Singkat</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                </div>

                <hr class="mb-6">

                <h2 class="text-lg font-bold mb-4">Pengaturan Jam Operasional</h2>
                
                @php
                    // Array nama hari (0 = Minggu, 1 = Senin, dst menyesuaikan standar date PHP)
                    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                @endphp

                <div class="space-y-4 mb-6">
                    @foreach($days as $index => $day)
                        <div class="flex items-center gap-4 p-3 border rounded bg-gray-50">
                            <div class="w-32">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="operating_hours[{{ $index }}][is_open]" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm" checked>
                                    <span class="ml-2 font-medium">{{ $day }}</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>Buka:</span>
                                <input type="time" name="operating_hours[{{ $index }}][open_time]" value="08:00" class="border rounded px-2 py-1">
                                
                                <span class="ml-4">Tutup:</span>
                                <input type="time" name="operating_hours[{{ $index }}][close_time]" value="22:00" class="border rounded px-2 py-1">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Simpan Lapangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>