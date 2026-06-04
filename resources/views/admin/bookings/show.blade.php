<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <x-organisms.sidebar />
            </aside>

            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-neutral-200 pb-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Detail Booking #{{ $booking->id }}</h1>
                        <p class="mt-2 text-sm text-neutral-500">Lihat data rincian pemesanan, riwayat pembayaran, dan ubah status transaksi.</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}">
                        <x-atoms.button type="secondary">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Column 1 & 2: Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Main Info Card -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
                            <h2 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Informasi Pemesanan</h2>
                            
                            <table class="w-full text-left">
                                <tr class="border-b border-slate-100">
                                    <th class="py-3 text-sm font-semibold text-neutral-500 w-1/3">Pelanggan</th>
                                    <td class="py-3 text-sm text-neutral-950 font-medium">{{ $booking->user->name ?? 'Guest' }} ({{ $booking->user->email ?? '-' }})</td>
                                </tr>
                                <tr class="border-b border-slate-100">
                                    <th class="py-3 text-sm font-semibold text-neutral-500">Lapangan</th>
                                    <td class="py-3 text-sm text-neutral-950 font-medium">{{ $booking->field->name ?? 'Lapangan' }}</td>
                                </tr>
                                <tr class="border-b border-slate-100">
                                    <th class="py-3 text-sm font-semibold text-neutral-500">Venue</th>
                                    <td class="py-3 text-sm text-neutral-950 font-medium">{{ $booking->field->venue->name ?? 'Venue' }}</td>
                                </tr>
                                <tr class="border-b border-slate-100">
                                    <th class="py-3 text-sm font-semibold text-neutral-500">Tanggal Main</th>
                                    <td class="py-3 text-sm text-neutral-950 font-medium">{{ $booking->booking_date->format('d M Y') }}</td>
                                </tr>
                                <tr class="border-b border-slate-100">
                                    <th class="py-3 text-sm font-semibold text-neutral-500">Total Harga</th>
                                    <td class="py-3 text-sm font-bold text-neutral-950">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="py-3 text-sm font-semibold text-neutral-500 align-top">Catatan Tambahan</th>
                                    <td class="py-3 text-sm text-neutral-600 whitespace-pre-line">{{ $booking->notes ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Slots Booked Card -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h2 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Daftar Slot Waktu</h2>
                            <div class="space-y-2">
                                @foreach($booking->slots as $slot)
                                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl bg-slate-50/50">
                                        <span class="text-sm font-semibold text-neutral-700">
                                            {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                        </span>
                                        <span class="text-sm font-bold text-neutral-900">
                                            Rp {{ number_format($slot->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Details Card -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
                            <h2 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Informasi Pembayaran</h2>
                            @if($booking->payment)
                                <table class="w-full text-left">
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500 w-1/3">Jumlah Bayar</th>
                                        <td class="py-3 text-sm text-neutral-950 font-medium">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Metode</th>
                                        <td class="py-3 text-sm text-neutral-950 font-medium uppercase">{{ $booking->payment->method }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Kode Referensi</th>
                                        <td class="py-3 text-sm text-neutral-950 font-mono">{{ $booking->payment->reference_code ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Tanggal Bayar</th>
                                        <td class="py-3 text-sm text-neutral-950">
                                            {{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 text-sm font-semibold text-neutral-500">Status Pembayaran</th>
                                        <td class="py-3 text-sm">
                                            @if($booking->payment->status === 'success')
                                                <x-atoms.badge variant="success">Berhasil</x-atoms.badge>
                                            @elseif($booking->payment->status === 'pending')
                                                <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                                            @else
                                                <x-atoms.badge variant="danger">Gagal</x-atoms.badge>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <div class="text-sm text-neutral-400 italic">Belum ada riwayat transaksi pembayaran.</div>
                            @endif
                        </div>
                    </div>

                    <!-- Column 3: Change Status -->
                    <div class="space-y-6">
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                            <h2 class="text-lg font-bold text-neutral-800 border-b border-slate-100 pb-2">Status Saat Ini</h2>
                            <div class="flex justify-center p-3 rounded-xl bg-slate-50 border border-slate-100">
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

                            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-100">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Ubah Status</label>
                                    <x-atoms.select name="status" :value="$booking->status" :options="[
                                        ['value' => 'pending', 'label' => 'Pending'],
                                        ['value' => 'paid', 'label' => 'Lunas (Paid)'],
                                        ['value' => 'completed', 'label' => 'Selesai'],
                                        ['value' => 'cancelled', 'label' => 'Dibatalkan'],
                                        ['value' => 'expired', 'label' => 'Kedaluwarsa'],
                                    ]" required />
                                </div>

                                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
