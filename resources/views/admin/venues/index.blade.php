<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <div class="flex justify-between items-center border-b border-neutral-200 pb-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Manajemen Venue</h1>
                        <p class="mt-2 text-sm text-neutral-500 font-normal">Kelola data semua venue dan tetapkan penanggung jawab admin.</p>
                    </div>
                    <a href="{{ route('admin.venues.create') }}">
                        <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                            + Tambah Venue
                        </x-atoms.button>
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Logo</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Nama Venue / Alamat</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Kota</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Admin Penanggung Jawab</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Kategori & Fasilitas</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($venues as $venue)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4">
                                        @if($venue->logo)
                                            <img src="{{ asset('storage/' . $venue->logo) }}" alt="Logo" class="w-12 h-12 object-cover rounded-xl border border-slate-100">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs font-semibold">
                                                No Logo
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-neutral-900 text-sm">{{ $venue->name }}</div>
                                        <div class="text-xs text-neutral-400 mt-0.5">{{ Str::limit($venue->address, 60) }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-neutral-600">{{ $venue->city }}</td>
                                    <td class="p-4 text-sm">
                                        @if($venue->admin)
                                            <div class="font-medium text-neutral-900">{{ $venue->admin->name }}</div>
                                            <div class="text-xs text-neutral-400">{{ $venue->admin->email }}</div>
                                            <div class="mt-1">
                                                <a href="{{ route('admin.venues.assign-admin', $venue->id) }}" class="text-primary-600 hover:text-primary-700 text-xs font-semibold underline">
                                                    Kelola Admin
                                                </a>
                                            </div>
                                        @else
                                            <a href="{{ route('admin.venues.assign-admin', $venue->id) }}" class="text-primary-600 hover:text-primary-700 text-xs font-semibold underline">
                                                Tugaskan Admin
                                            </a>
                                        @endif
                                    </td>
                                    <td class="p-4 space-y-1">
                                        <!-- Categories -->
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($venue->sportsCategories as $cat)
                                                <span class="bg-primary-50 text-primary-700 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                                    {{ $cat->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <!-- Facilities -->
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($venue->facilities as $fac)
                                                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-1.5 py-0.5 rounded-full">
                                                    {{ $fac->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.venues.show', $venue->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.venues.edit', $venue->id) }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus venue ini? Lapangan yang ada di dalam venue juga akan terhapus.')">
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
                                    <td colspan="6" class="p-8 text-center text-sm text-neutral-400 italic">Belum ada data venue.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $venues->links() }}
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
