<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <x-organisms.sidebar />
            </aside>

            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <div class="flex justify-between items-center border-b border-neutral-200 pb-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Manajemen Lapangan</h1>
                        <p class="mt-2 text-sm text-neutral-500">Kelola lapangan olahraga, jam operasional harian, dan galeri foto.</p>
                    </div>
                    <a href="{{ route('admin.fields.create') }}">
                        <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                            + Tambah Lapangan
                        </x-atoms.button>
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Foto</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Nama Lapangan</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Kategori / Venue</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Status Operasional</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fields as $field)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4">
                                        @php
                                            $primaryImage = $field->images->where('is_primary', true)->first();
                                        @endphp
                                        @if($primaryImage)
                                            <img
                                                src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                                alt="Foto Lapangan"
                                                class="w-16 h-16 object-cover rounded-xl border border-slate-100">
                                        @else
                                            <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs italic">
                                                No Photo
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4 font-semibold text-neutral-900 text-sm">
                                        {{ $field->name }}
                                    </td>
                                    
                                    <td class="p-4 text-sm text-neutral-600">
                                        <div class="font-medium">{{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}</div>
                                        <div class="text-xs text-neutral-400 mt-0.5">{{ $field->venue->name ?? 'Venue Dihapus' }}</div>
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            @if($field->is_active)
                                                <x-atoms.badge variant="success">Buka / Aktif</x-atoms.badge>
                                            @else
                                                <x-atoms.badge variant="danger">Tutup Sementara</x-atoms.badge>
                                            @endif
                                            
                                            <!-- Toggle Status (Quick Action) -->
                                            <form action="{{ route('admin.fields.toggle-status', $field->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs font-semibold px-2.5 py-1 rounded-lg border transition-colors {{ $field->is_active ? 'border-red-200 text-red-600 hover:bg-red-50' : 'border-green-200 text-green-600 hover:bg-green-50' }}">
                                                    {{ $field->is_active ? 'Tutup Lapangan' : 'Buka Lapangan' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.fields.show', $field->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.fields.edit', $field->id) }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini beserta fotonya secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-sm text-neutral-400 italic">Belum ada data lapangan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $fields->links() }}
                </div>
            </main>
        </div>
    </div>
</x-app-layout>