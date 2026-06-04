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
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Lapangan: {{ $field->name }}</h1>
                        <p class="mt-2 text-sm text-neutral-500">Lihat data lengkap lapangan, foto galeri, dan jam operasional harian.</p>
                    </div>
                    <a href="{{ route('admin.fields.index') }}">
                        <x-atoms.button type="secondary">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Detail Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
                            <!-- Main Photo -->
                            <div>
                                @php
                                    $primaryImage = $field->images->where('is_primary', true)->first();
                                @endphp
                                @if($primaryImage)
                                    <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="Foto Utama" class="w-full h-80 object-cover rounded-2xl border border-slate-100">
                                @else
                                    <div class="w-full h-80 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 font-semibold italic text-sm">
                                        Belum ada foto utama.
                                    </div>
                                @endif
                            </div>

                            <!-- Spec Table -->
                            <div class="overflow-hidden">
                                <table class="w-full text-left">
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500 w-1/3">Nama Lapangan</th>
                                        <td class="py-3 text-sm font-semibold text-neutral-900">{{ $field->name }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Kategori</th>
                                        <td class="py-3 text-sm">
                                            <span class="bg-primary-50 text-primary-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                                {{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Venue Induk</th>
                                        <td class="py-3 text-sm text-neutral-900 font-medium">{{ $field->venue->name ?? 'Venue Dihapus' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Status</th>
                                        <td class="py-3 text-sm">
                                            @if($field->is_active)
                                                <x-atoms.badge variant="success">Buka / Aktif</x-atoms.badge>
                                            @else
                                                <x-atoms.badge variant="danger">Tutup Sementara</x-atoms.badge>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 text-sm font-semibold text-neutral-500 align-top">Deskripsi</th>
                                        <td class="py-3 text-sm text-neutral-600 whitespace-pre-line">{{ $field->description ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Gallery list (Readonly on show page) -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h3 class="text-lg font-bold text-neutral-800">Galeri Foto</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach($field->images as $image)
                                    <div class="border border-slate-200 rounded-2xl p-2 bg-slate-50/50 flex flex-col items-center">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-20 object-cover rounded-xl border border-slate-100">
                                        @if($image->is_primary)
                                            <span class="mt-2 bg-green-50 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                Primary
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Operating Hours & Pricings -->
                    <div class="space-y-6">
                        <!-- Pricing Tiers card -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h3 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Tarif Sewa per Slot</h3>
                            <ul class="space-y-3">
                                @forelse($field->pricings as $pricing)
                                    @php
                                        $tierName = $pricing->day_type === 'weekday' ? 'Regular (Weekday)' : ($pricing->day_type === 'weekend' ? 'Weekend' : 'Holiday');
                                    @endphp
                                    <li class="flex justify-between items-center p-3 rounded-xl bg-slate-50/50 border border-slate-100">
                                        <span class="text-sm font-semibold text-neutral-700">{{ $tierName }}</span>
                                        <span class="text-sm font-bold text-green-600">Rp {{ number_format($pricing->price_per_slot, 0, ',', '.') }}</span>
                                    </li>
                                @empty
                                    <li class="text-sm text-neutral-400 italic">Tarif belum diatur.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Operating Hours card -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h3 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Jam Operasional</h3>
                            
                            <ul class="space-y-3">
                                @php
                                    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                @endphp

                                @forelse($field->operatingHours->sortBy('day_of_week') as $hour)
                                    <li class="flex justify-between items-center p-2.5 rounded-xl border border-slate-100 {{ $hour->is_open ? 'bg-slate-50/50' : 'bg-red-50/30' }}">
                                        <span class="text-sm font-semibold text-neutral-700">{{ $hari[$hour->day_of_week] }}</span>
                                        
                                        @if($hour->is_open)
                                            <span class="text-xs font-semibold bg-white border border-slate-200 px-2.5 py-1 rounded-lg text-neutral-600">
                                                {{ \Carbon\Carbon::parse($hour->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($hour->close_time)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-red-600 bg-white border border-red-100 px-2.5 py-1 rounded-lg">
                                                Tutup
                                            </span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="text-neutral-400 italic text-sm">Jam operasional belum diatur.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>