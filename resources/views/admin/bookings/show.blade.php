<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Booking #{{ $booking->id }}</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Lihat data rincian pemesanan, riwayat pembayaran, dan ubah status transaksi.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.bookings.index') }}">
                        <x-atoms.button type="secondary" class="px-5 py-2.5 text-sm font-semibold shadow-sm">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Column 1 & 2: Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Main Info Card -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-6">
                        <h2 class="text-lg font-bold text-neutral-800 border-b border-neutral-100 pb-2">Informasi Pemesanan</h2>

                        <div class="overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/30">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-neutral-100">
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 w-1/3 bg-slate-50/50">Pelanggan</th>
                                        <td class="p-4 text-sm text-neutral-950 font-medium bg-white">{{ $booking->user->name ?? 'Guest' }} ({{ $booking->user->email ?? '-' }})</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Lapangan</th>
                                        <td class="p-4 text-sm text-neutral-950 font-semibold bg-white">{{ $field->name ?? ($booking->field->name ?? 'Lapangan') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Venue</th>
                                        <td class="p-4 text-sm text-neutral-950 font-medium bg-white">{{ $booking->field->venue->name ?? 'Venue' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Tanggal Main</th>
                                        <td class="p-4 text-sm text-neutral-950 font-semibold bg-white">{{ $booking->booking_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Total Harga</th>
                                        <td class="p-4 text-sm font-extrabold text-neutral-950 bg-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-4 text-sm font-semibold text-neutral-500 align-top bg-slate-50/50">Catatan Tambahan</th>
                                        <td class="p-4 text-sm text-neutral-600 whitespace-pre-line bg-white leading-relaxed">{{ $booking->notes ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Slots Booked Card -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h2 class="text-lg font-bold text-neutral-800 border-b border-neutral-100 pb-2">Daftar Slot Waktu</h2>
                        <div class="space-y-2">
                            @foreach($booking->slots as $slot)
                                <div class="flex justify-between items-center p-3.5 border border-neutral-100 rounded-xl bg-neutral-50/30">
                                    <span class="text-sm font-semibold text-neutral-700">
                                        {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                    </span>
                                    <span class="text-sm font-extrabold text-neutral-900">
                                        Rp {{ number_format($slot->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Details Card -->
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-6">
                        <h2 class="text-lg font-bold text-neutral-800 border-b border-neutral-100 pb-2">Informasi Pembayaran</h2>
                        @if($booking->payment)
                            <div class="overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/30">
                                <table class="w-full text-left border-collapse">
                                    <tbody class="divide-y divide-neutral-100">
                                        <tr>
                                            <th class="p-4 text-sm font-semibold text-neutral-500 w-1/3 bg-slate-50/50">Jumlah Bayar</th>
                                            <td class="p-4 text-sm text-neutral-950 font-bold bg-white">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Metode</th>
                                            <td class="p-4 text-sm text-neutral-950 font-semibold uppercase bg-white">{{ $booking->payment->method }}</td>
                                        </tr>
                                        <tr>
                                            <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Kode Referensi</th>
                                            <td class="p-4 text-sm text-neutral-950 font-mono bg-white">{{ $booking->payment->reference_code ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Tanggal Bayar</th>
                                            <td class="p-4 text-sm text-neutral-950 bg-white font-medium">
                                                {{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d M Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="p-4 text-sm font-semibold text-neutral-500 bg-slate-50/50">Status Pembayaran</th>
                                            <td class="p-4 text-sm bg-white">
                                                @if($booking->payment->status === 'success')
                                                    <x-atoms.badge variant="success">Berhasil</x-atoms.badge>
                                                @elseif($booking->payment->status === 'pending')
                                                    <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                                                @else
                                                    <x-atoms.badge variant="danger">Gagal</x-atoms.badge>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-sm text-neutral-400 italic text-center py-4">Belum ada riwayat transaksi pembayaran.</div>
                        @endif
                    </div>
                </div>

                <!-- Column 3: Change Status -->
                <div class="space-y-6">
                    <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6 space-y-4">
                        <h2 class="text-lg font-bold text-neutral-800 border-b border-neutral-100 pb-2.5">Status Saat Ini</h2>
                        <div class="flex justify-center p-4 rounded-xl bg-neutral-50 border border-neutral-100/60 shadow-sm">
                            @if($booking->status === 'paid')
                                <x-atoms.badge variant="success" class="text-sm px-4 py-1.5">Lunas (Paid)</x-atoms.badge>
                            @elseif($booking->status === 'pending')
                                <x-atoms.badge variant="warning" class="text-sm px-4 py-1.5">Pending</x-atoms.badge>
                            @elseif($booking->status === 'completed')
                                <x-atoms.badge variant="success" class="text-sm px-4 py-1.5">Selesai</x-atoms.badge>
                            @elseif($booking->status === 'cancelled')
                                <x-atoms.badge variant="danger" class="text-sm px-4 py-1.5">Dibatalkan</x-atoms.badge>
                            @else
                                <x-atoms.badge variant="danger" class="text-sm px-4 py-1.5">Expired</x-atoms.badge>
                            @endif
                        </div>

                        <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="space-y-4 pt-4 border-t border-neutral-100">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Ubah Status</label>
                                <x-atoms.select name="status" :value="$booking->status" :options="[
                                    ['value' => 'pending', 'label' => 'Pending'],
                                    ['value' => 'paid', 'label' => 'Lunas (Paid)'],
                                    ['value' => 'completed', 'label' => 'Selesai'],
                                    ['value' => 'cancelled', 'label' => 'Dibatalkan'],
                                    ['value' => 'expired', 'label' => 'Kedaluwarsa'],
                                ]" required />
                            </div>

                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-sm">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
