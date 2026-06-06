<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Manajemen Lapangan</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Kelola lapangan olahraga, jam operasional harian, dan galeri foto.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.fields.create') }}">
                        <x-atoms.button type="primary" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold shadow-sm hover:shadow transition-all">
                            + Tambah Lapangan
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Foto</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Nama Lapangan</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Kategori / Venue</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Status Operasional</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($fields as $field)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4">
                                        @php
                                            $primaryImage = $field->images->where('is_primary', true)->first();
                                        @endphp
                                        @if($primaryImage)
                                            <img
                                                src="{{ $primaryImage->url }}"
                                                alt="Foto Lapangan"
                                                class="w-16 h-16 object-cover rounded-xl border border-neutral-100 shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-neutral-100 rounded-xl flex items-center justify-center text-neutral-400 text-[10px] font-bold uppercase">
                                                No Photo
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4 font-bold text-neutral-900 text-sm hover:text-primary-500 transition-colors">
                                        <a href="{{ route('admin.fields.show', $field->id) }}">{{ $field->name }}</a>
                                    </td>

                                    <td class="p-4 text-sm text-neutral-600 font-medium">
                                        <div class="font-bold text-neutral-900">{{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}</div>
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
                                            <form action="{{ route('admin.fields.toggle-status', $field->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg border transition-colors {{ $field->is_active ? 'border-danger-200 text-danger-600 hover:bg-danger-50' : 'border-success-200 text-success-600 hover:bg-success-50' }}">
                                                    {{ $field->is_active ? 'Tutup' : 'Buka' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.fields.show', $field->id) }}" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.fields.edit', $field->id) }}" class="bg-warning-100 text-warning-700 hover:bg-warning-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini beserta fotonya secara permanen?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-danger-100 text-danger-700 hover:bg-danger-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
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
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $fields->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
