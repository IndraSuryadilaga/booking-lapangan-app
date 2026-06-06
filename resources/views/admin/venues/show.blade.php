<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Venue: {{ $venue->name }}</h1>
                    <p class="mt-2 text-sm text-neutral-500">Lihat data lengkap venue, fasilitas, dan olahraga yang tersedia.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.venues.index') }}">
                        <x-atoms.button type="secondary" class="px-5 py-2.5 text-sm font-semibold shadow-sm">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Detail Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-6">
                        <!-- Logo & Name -->
                        <div class="flex items-center gap-6 pb-6 border-b border-neutral-100">
                            @if($venue->logo_url)
                                <img src="{{ $venue->logo_url }}" alt="Logo Venue" class="w-24 h-24 object-cover rounded-2xl border border-neutral-100 shadow-sm bg-neutral-50">
                            @else
                                <div class="w-24 h-24 bg-neutral-100 rounded-2xl flex items-center justify-center text-neutral-400 font-bold uppercase text-[10px]">
                                    No Logo
                                </div>
                            @endif
                            <div>
                                <h2 class="text-2xl font-bold text-neutral-900 tracking-tight">{{ $venue->name }}</h2>
                                <p class="text-sm text-neutral-500 mt-1 font-medium">{{ $venue->city }}, {{ $venue->province }}</p>
                            </div>
                        </div>

                        <!-- Spec Table -->
                        <div class="overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/30">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-neutral-100">
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 w-1/3 bg-slate-50/50">Alamat</th>
                                        <td class="p-4 text-sm text-neutral-900 font-medium bg-white leading-relaxed">{{ $venue->address }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Latitude</th>
                                        <td class="p-4 text-sm text-neutral-900 font-medium bg-white">{{ $venue->latitude ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Longitude</th>
                                        <td class="p-4 text-sm text-neutral-900 font-medium bg-white">{{ $venue->longitude ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 align-top bg-slate-50/50">Kebijakan Refund</th>
                                        <td class="p-4 text-sm text-neutral-600 whitespace-pre-line bg-white leading-relaxed">{{ $venue->refund_policy ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 align-top bg-slate-50/50">Kebijakan Reschedule</th>
                                        <td class="p-4 text-sm text-neutral-600 whitespace-pre-line bg-white leading-relaxed">{{ $venue->reschedule_policy ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sports & Facilities -->
                <div class="space-y-6">
                    <!-- Sports Categories -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-base font-bold text-neutral-800 border-b border-neutral-100 pb-2.5">Kategori Olahraga</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($venue->sportsCategories as $category)
                                <span class="bg-primary-100/50 text-primary-600 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-sm text-neutral-400 italic">Belum ada kategori olahraga.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-base font-bold text-neutral-800 border-b border-neutral-100 pb-2.5">Fasilitas</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($venue->facilities as $facility)
                                <span class="bg-neutral-100 text-neutral-500 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $facility->name }}
                                </span>
                            @empty
                                <span class="text-sm text-neutral-400 italic">Belum ada fasilitas.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
