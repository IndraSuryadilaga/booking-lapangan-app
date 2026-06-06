<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Lapangan: {{ $field->name }}</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Lihat data lengkap lapangan, foto galeri, dan jam operasional harian.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.fields.index') }}">
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
                        <!-- Main Photo -->
                        <div>
                            @php
                                $primaryImage = $field->images->where('is_primary', true)->first();
                            @endphp
                            @if($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="Foto Utama" class="w-full h-80 object-cover rounded-2xl border border-neutral-100 shadow-sm">
                            @else
                                <div class="w-full h-80 bg-neutral-100 rounded-2xl flex items-center justify-center text-neutral-400 font-bold uppercase text-[10px]">
                                    Belum ada foto utama.
                                </div>
                            @endif
                        </div>

                        <!-- Spec Table -->
                        <div class="overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/30">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-neutral-100">
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 w-1/3 bg-slate-50/50">Nama Lapangan</th>
                                        <td class="p-4 text-sm font-bold text-neutral-900 bg-white">{{ $field->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Kategori</th>
                                        <td class="p-4 text-sm bg-white">
                                            <span class="bg-primary-100/50 text-primary-600 text-xs font-bold px-3 py-1 rounded-full">
                                                {{ $field->sportsCategory->name ?? 'Kategori Dihapus' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Venue Induk</th>
                                        <td class="p-4 text-sm text-neutral-900 font-semibold bg-white">{{ $field->venue->name ?? 'Venue Dihapus' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Status</th>
                                        <td class="p-4 text-sm bg-white">
                                            @if($field->is_active)
                                                <x-atoms.badge variant="success">Buka / Aktif</x-atoms.badge>
                                            @else
                                                <x-atoms.badge variant="danger">Tutup Sementara</x-atoms.badge>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 align-top bg-slate-50/50">Deskripsi</th>
                                        <td class="p-4 text-sm text-neutral-600 whitespace-pre-line bg-white leading-relaxed">{{ $field->description ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Gallery list (Readonly on show page) -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-base font-bold text-neutral-800">Galeri Foto</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @forelse($field->images as $image)
                                <div class="border border-neutral-100 rounded-2xl p-2 bg-neutral-50/50 flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-20 object-cover rounded-xl border border-neutral-100 shadow-sm">
                                    @if($image->is_primary)
                                        <span class="mt-2 bg-success-50 border border-success-200 text-success-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            Primary
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="col-span-full py-4 text-center text-sm text-neutral-400 italic">Belum ada foto galeri.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Operating Hours & Pricings -->
                <div class="space-y-6">
                    <!-- Pricing Tiers card -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-base font-bold text-neutral-800 border-b border-neutral-100 pb-2.5">Tarif Sewa per Slot</h3>
                        <ul class="space-y-3">
                            @forelse($field->pricings as $pricing)
                                @php
                                    $tierName = $pricing->day_type === 'weekday' ? 'Regular (Weekday)' : ($pricing->day_type === 'weekend' ? 'Weekend' : 'Holiday');
                                @endphp
                                <li class="flex justify-between items-center p-3 rounded-xl bg-neutral-50/50 border border-neutral-100">
                                    <span class="text-sm font-semibold text-neutral-700">{{ $tierName }}</span>
                                    <span class="text-sm font-extrabold text-success-600">Rp {{ number_format($pricing->price_per_slot, 0, ',', '.') }}</span>
                                </li>
                            @empty
                                <li class="text-sm text-neutral-400 italic text-center py-2">Tarif belum diatur.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Operating Hours card -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-base font-bold text-neutral-800 border-b border-neutral-100 pb-2.5">Jam Operasional</h3>

                        <ul class="space-y-3">
                            @php
                                $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            @endphp

                            @forelse($field->operatingHours->sortBy('day_of_week') as $hour)
                                <li class="flex justify-between items-center p-2.5 rounded-xl border border-neutral-150 {{ $hour->is_open ? 'bg-neutral-50/50 border-neutral-100' : 'bg-danger-50/30 border-danger-100' }}">
                                    <span class="text-sm font-semibold text-neutral-700">{{ $hari[$hour->day_of_week] }}</span>

                                    @if($hour->is_open)
                                        <span class="text-xs font-bold bg-white border border-neutral-200 px-2.5 py-1 rounded-lg text-neutral-600 shadow-sm">
                                            {{ \Carbon\Carbon::parse($hour->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($hour->close_time)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-xs font-bold text-danger-700 bg-white border border-danger-100 px-2.5 py-1 rounded-lg shadow-sm">
                                            Tutup
                                        </span>
                                    @endif
                                </li>
                            @empty
                                <li class="text-neutral-400 italic text-sm text-center py-2">Jam operasional belum diatur.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
