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
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Fasilitas Venue</h1>
                        <p class="mt-2 text-sm text-neutral-500">Kelola daftar fasilitas umum (seperti Wi-Fi, Parkir, Shower) yang dapat dikaitkan dengan venue.</p>
                    </div>
                    <a href="{{ route('facilities.create') }}">
                        <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                            + Tambah Fasilitas
                        </x-atoms.button>
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">ID</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Nama Fasilitas</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($facilities as $facility)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 text-sm text-neutral-600">
                                        #{{ $facility->id }}
                                    </td>
                                    
                                    <td class="p-4 font-semibold text-neutral-900 text-sm">
                                        {{ $facility->name }}
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('facilities.edit', $facility->id) }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini secara permanen?')">
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
                                    <td colspan="3" class="p-8 text-center text-neutral-500 text-sm italic">
                                        Belum ada fasilitas yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
