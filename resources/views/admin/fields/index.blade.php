<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Lapangan</h1>
            <a href="{{ route('fields.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Lapangan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 border-b">Foto</th>
                        <th class="p-4 border-b">Nama Lapangan</th>
                        <th class="p-4 border-b">Kategori</th>
                        <th class="p-4 border-b">Harga/Slot</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fields as $field)
                        <tr>
                            <td class="p-4 border-b">
                                @if($field->photo)
                                    <img src="{{ asset('storage/' . $field->photo) }}" alt="Foto Lapangan" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-sm italic">Belum ada foto</span>
                                @endif
                            </td>
                            
                            <td class="p-4 border-b font-medium">{{ $field->name }}</td>
                            <td class="p-4 border-b">{{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}</td>
                            <td class="p-4 border-b">Rp {{ number_format($field->price_per_slot, 0, ',', '.') }}</td>
                            
                            <td class="p-4 border-b text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('fields.show', $field->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Detail</a>

                                    <a href="{{ route('fields.edit', $field->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>

                                    <form action="{{ route('fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini beserta fotonya secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500 italic">Belum ada data lapangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>