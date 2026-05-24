<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Lapangan: {{ $field->name }}</h1>
            <a href="{{ route('fields.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
                <div class="mb-4">
                    @if($field->photo)
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="Foto {{ $field->name }}" class="w-full h-64 object-cover rounded-lg border">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg border">
                            <span class="text-gray-500">Tidak ada foto</span>
                        </div>
                    @endif
                </div>

                <table class="w-full text-left">
                    <tr class="border-b">
                        <th class="py-2 text-gray-600 w-1/3">Nama Lapangan</th>
                        <td class="py-2 font-medium">{{ $field->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 text-gray-600">Kategori</th>
                        <td class="py-2">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                {{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 text-gray-600">Harga per Slot</th>
                        <td class="py-2 font-bold text-green-600">Rp {{ number_format($field->price_per_slot, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 text-gray-600">Status</th>
                        <td class="py-2">
                            @if($field->is_active)
                                <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="py-2 text-gray-600 align-top">Deskripsi</th>
                        <td class="py-2 whitespace-pre-wrap">{{ $field->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Jam Operasional</h2>
                
                <ul class="space-y-3">
                    @php
                        // Array untuk mapping hari angka ke nama hari
                        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    @endphp

                    @forelse($field->operatingHours->sortBy('day_of_week') as $hour)
                        <li class="flex justify-between items-center p-2 rounded {{ $hour->is_open ? 'bg-gray-50' : 'bg-red-50' }}">
                            <span class="font-medium w-20">{{ $hari[$hour->day_of_week] }}</span>
                            
                            @if($hour->is_open)
                                <span class="text-sm bg-white border px-2 py-1 rounded">
                                    {{ \Carbon\Carbon::parse($hour->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($hour->close_time)->format('H:i') }}
                                </span>
                            @else
                                <span class="text-sm text-red-600 font-bold bg-white border border-red-200 px-2 py-1 rounded">Tutup</span>
                            @endif
                        </li>
                    @empty
                        <li class="text-gray-500 italic text-sm">Jadwal belum diatur.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>