<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Transaksi</h1>
                <p class="text-sm text-slate-500 mt-2">Daftar semua pesanan lapangan Anda yang sudah selesai, dibatalkan, atau kedaluwarsa.</p>
            </div>
            <a href="{{ route('venues.index') }}">
                <x-atoms.button type="primary">Cari Lapangan Lain</x-atoms.button>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                        <th class="p-4 sm:px-6 font-bold">Tempat & Tanggal</th>
                        <th class="p-4 sm:px-6 font-bold">Total Harga</th>
                        <th class="p-4 sm:px-6 font-bold">Status</th>
                        <th class="p-4 sm:px-6 font-bold text-right">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 sm:px-6">
                                <div class="font-bold text-slate-900">{{ $booking->field->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $booking->field->venue->name ?? '' }}</div>
                                <div class="text-xs text-primary-600 font-medium mt-1">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="p-4 sm:px-6 font-bold text-slate-700">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                            <td class="p-4 sm:px-6">
                                @if($booking->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                                @elseif($booking->status === 'paid' || $booking->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Lunas</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Dibatalkan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Kedaluwarsa</span>
                                @endif
                            </td>
                            <td class="p-4 sm:px-6 text-right space-x-3">
                                <!-- Logika Tombol Beri Ulasan / Sewa Lagi -->
                                @if($booking->status === 'completed' && !$booking->review)
                                    <a href="{{ route('reviews.create', $booking->id) }}" class="text-sm font-bold text-amber-500 hover:text-amber-700 transition-colors">
                                        Beri Ulasan
                                    </a>
                                @endif
                                <!-- Tombol E-Tiket -->
                                <a href="{{ route('bookings.show', $booking->id) }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                    Tiket
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">Belum ada riwayat</h3>
                                    <p class="text-xs text-slate-500 mt-1">Anda belum memiliki transaksi yang selesai atau dibatalkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
