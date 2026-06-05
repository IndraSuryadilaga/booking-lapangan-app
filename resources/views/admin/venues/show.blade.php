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
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Venue: {{ $venue->name }}</h1>
                        <p class="mt-2 text-sm text-neutral-500">Lihat data lengkap venue, fasilitas, dan olahraga yang tersedia.</p>
                    </div>
                    <a href="{{ route('admin.venues.index') }}">
                        <x-atoms.button type="secondary">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Detail Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
                            <!-- Logo & Name -->
                            <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                                @if($venue->logo)
                                    <img src="{{ asset('storage/' . $venue->logo) }}" alt="Logo Venue" class="w-24 h-24 object-cover rounded-2xl border border-slate-100 shadow-sm bg-neutral-50">
                                @else
                                    <div class="w-24 h-24 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 font-semibold italic text-xs">
                                        No Logo
                                    </div>
                                @endif
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900">{{ $venue->name }}</h2>
                                    <p class="text-sm text-neutral-500 mt-1">{{ $venue->city }}, {{ $venue->province }}</p>
                                </div>
                            </div>

                            <!-- Spec Table -->
                            <div class="overflow-hidden">
                                <table class="w-full text-left">
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500 w-1/3">Alamat</th>
                                        <td class="py-3 text-sm text-neutral-900 font-medium">{{ $venue->address }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Latitude</th>
                                        <td class="py-3 text-sm text-neutral-900 font-medium">{{ $venue->latitude ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Longitude</th>
                                        <td class="py-3 text-sm text-neutral-900 font-medium">{{ $venue->longitude ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500 align-top">Kebijakan Refund</th>
                                        <td class="py-3 text-sm text-neutral-600 whitespace-pre-line">{{ $venue->refund_policy ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 text-sm font-semibold text-neutral-500 align-top">Kebijakan Reschedule</th>
                                        <td class="py-3 text-sm text-neutral-600 whitespace-pre-line">{{ $venue->reschedule_policy ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Sports & Facilities -->
                    <div class="space-y-6">
                        <!-- Sports Categories -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h3 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Kategori Olahraga</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($venue->sportsCategories as $category)
                                    <span class="bg-primary-50 text-primary-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-neutral-400 italic">Belum ada kategori olahraga.</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h3 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Fasilitas</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($venue->facilities as $facility)
                                    <span class="bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                        {{ $facility->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-neutral-400 italic">Belum ada fasilitas.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
