<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Lapangan: {{ $field->name }}</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
            <form action="{{ route('fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Kategori Olahraga</label>
                    <select name="sports_category_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $field->sports_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2 font-medium">Nama Lapangan</label>
                        <input type="text" name="name" value="{{ $field->name }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">Harga per Slot (Rp)</label>
                        <input type="number" name="price_per_slot" value="{{ $field->price_per_slot }}" min="0" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Foto Lapangan (Biarkan kosong jika tidak ingin ganti) Maks : 10MB</label>
                    @if($field->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $field->photo) }}" class="w-32 h-20 object-cover rounded border">
                        </div>
                    @endif
                    <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-medium">Deskripsi Singkat</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ $field->description }}</textarea>
                </div>

                <hr class="mb-6">
                <h2 class="text-lg font-bold mb-4">Pengaturan Jam Operasional</h2>
                
                @php
                    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $currentHours = $field->operatingHours->keyBy('day_of_week');
                @endphp

                <div class="space-y-4 mb-6">
                    @foreach($days as $index => $day)
                        @php
                            $data = $currentHours->get($index);
                        @endphp
                        <div class="flex items-center gap-4 p-3 border rounded {{ ($data && $data->is_open) ? 'bg-gray-50' : 'bg-red-50' }}">
                            <div class="w-32">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="operating_hours[{{ $index }}][is_open]" value="1" 
                                           {{ ($data && $data->is_open) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2 font-medium">{{ $day }}</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>Buka:</span>
                                <input type="time" name="operating_hours[{{ $index }}][open_time]" 
                                       value="{{ $data ? \Carbon\Carbon::parse($data->open_time)->format('H:i') : '08:00' }}" class="border rounded px-2 py-1">
                                
                                <span class="ml-4">Tutup:</span>
                                <input type="time" name="operating_hours[{{ $index }}][close_time]" 
                                       value="{{ $data ? \Carbon\Carbon::parse($data->close_time)->format('H:i') : '22:00' }}" class="border rounded px-2 py-1">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('fields.index') }}" class="bg-gray-500 text-white py-2 px-6 rounded">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>