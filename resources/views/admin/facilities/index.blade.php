<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Fasilitas Venue</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Kelola daftar fasilitas umum (seperti Wi-Fi, Parkir, Shower) yang dapat dikaitkan dengan venue.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('facilities.create') }}">
                        <x-atoms.button type="primary" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold shadow-sm hover:shadow transition-all">
                            + Tambah Fasilitas
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">ID</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Nama Fasilitas</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse ($facilities as $facility)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 text-sm text-neutral-600 font-mono">
                                        #{{ $facility->id }}
                                    </td>

                                    <td class="p-4 font-bold text-neutral-900 text-sm">
                                        {{ $facility->name }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('facilities.edit', $facility->id) }}" class="bg-warning-100 text-warning-700 hover:bg-warning-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Edit
                                            </a>

                                            <button
                                                type="button"
                                                class="bg-danger-100 text-danger-700 hover:bg-danger-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm"
                                                x-data
                                                @click="$dispatch('open-modal', 'confirm-delete-facility-{{ $facility->id }}')"
                                            >
                                                Hapus
                                            </button>

                                            <!-- Delete Confirmation Modal -->
                                            <x-organisms.modal name="confirm-delete-facility-{{ $facility->id }}" maxWidth="sm">
                                                <div class="p-6 space-y-4 text-left">
                                                    <h3 class="text-lg font-bold text-neutral-900 tracking-tight">Hapus Fasilitas</h3>
                                                    <p class="text-sm text-neutral-500 leading-relaxed">
                                                        Apakah Anda yakin ingin menghapus fasilitas <strong class="text-neutral-800">{{ $facility->name }}</strong> secara permanen? Tindakan ini tidak dapat dibatalkan.
                                                    </p>
                                                    <div class="flex justify-end gap-3 pt-3 border-t border-neutral-100">
                                                        <button type="button" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 px-4 py-2 rounded-xl text-sm font-bold transition-colors" x-data @click="$dispatch('close-modal', 'confirm-delete-facility-{{ $facility->id }}')">
                                                            Batal
                                                        </button>
                                                        <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-danger-600 hover:bg-danger-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors">
                                                                Ya, Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </x-organisms.modal>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-neutral-400 text-sm italic">
                                        Belum ada fasilitas yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
