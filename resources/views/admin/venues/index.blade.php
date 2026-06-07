<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Manajemen Venue</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Kelola data semua venue dan tetapkan penanggung jawab admin.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.venues.create') }}">
                        <x-atoms.button type="primary" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold shadow-sm hover:shadow transition-all">
                            + Tambah Venue
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Logo</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Nama Venue / Alamat</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Kota</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Admin Penanggung Jawab</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Kategori & Fasilitas</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($venues as $venue)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4">
                                        @if($venue->logo_url)
                                            <img src="{{ $venue->logo_url }}" alt="Logo" class="w-12 h-12 object-cover rounded-xl border border-neutral-100 shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center text-neutral-400 text-[10px] font-bold uppercase">
                                                No Logo
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-neutral-900 text-sm hover:text-primary-500 transition-colors">
                                            <a href="{{ route('admin.venues.show', $venue->id) }}">{{ $venue->name }}</a>
                                        </div>
                                        <div class="text-xs text-neutral-400 mt-1 leading-relaxed">{{ Str::limit($venue->address, 65) }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-neutral-600 font-medium">{{ $venue->city }}</td>
                                    <td class="p-4 text-sm">
                                        @if($venue->admin)
                                            <div class="font-semibold text-neutral-900">{{ $venue->admin->name }}</div>
                                            <div class="text-xs text-neutral-400 mt-0.5">{{ $venue->admin->email }}</div>
                                            <div class="mt-1.5">
                                                <a href="{{ route('admin.venues.assign-admin', $venue->id) }}" class="text-primary-500 hover:text-primary-600 text-xs font-bold hover:underline">
                                                    Kelola Admin
                                                </a>
                                            </div>
                                        @else
                                            <a href="{{ route('admin.venues.assign-admin', $venue->id) }}" class="text-primary-500 hover:text-primary-600 text-xs font-bold hover:underline">
                                                Tugaskan Admin
                                            </a>
                                        @endif
                                    </td>
                                    <td class="p-4 space-y-1.5">
                                        <!-- Categories -->
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($venue->sportsCategories as $cat)
                                                <span class="bg-primary-100/50 text-primary-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                    {{ $cat->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <!-- Facilities -->
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($venue->facilities as $fac)
                                                <span class="bg-neutral-100 text-neutral-500 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                    {{ $fac->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.venues.show', $venue->id) }}" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.venues.edit', $venue->id) }}" class="bg-warning-100 text-warning-700 hover:bg-warning-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus venue ini? Lapangan yang ada di dalam venue juga akan terhapus.')" class="inline">
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
                                    <td colspan="6" class="p-8 text-center text-sm text-neutral-400 italic">Belum ada data venue.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $venues->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
