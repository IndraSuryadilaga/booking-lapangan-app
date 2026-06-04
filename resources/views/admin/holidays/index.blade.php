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
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Hari Libur Nasional</h1>
                        <p class="mt-2 text-sm text-neutral-500">Kelola daftar hari libur nasional. Hari libur ini akan memicu penerapan tarif khusus libur (holiday tier) pada saat pemesanan lapangan.</p>
                    </div>
                    <a href="{{ route('holidays.create') }}">
                        <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                            + Tambah Hari Libur
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
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Nama Hari Libur</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Tanggal</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($holidays as $holiday)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 text-sm text-neutral-600">
                                        #{{ $holiday->id }}
                                    </td>
                                    
                                    <td class="p-4 font-semibold text-neutral-900 text-sm">
                                        {{ $holiday->name }}
                                    </td>

                                    <td class="p-4 text-neutral-600 text-sm">
                                        {{ \Carbon\Carbon::parse($holiday->holiday_date)->translatedFormat('d F Y') }}
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('holidays.edit', $holiday->id) }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hari libur ini secara permanen?')">
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
                                    <td colspan="4" class="p-8 text-center text-neutral-500 text-sm italic">
                                        Belum ada hari libur nasional yang terdaftar.
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
