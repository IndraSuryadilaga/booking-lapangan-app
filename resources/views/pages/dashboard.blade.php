<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 pt-28">

        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Utama</h1>
                <p class="text-sm text-slate-500 mt-2">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            @if (Auth::user()->role !== 'admin')
                <a href="{{ route('venues.index') }}">
                    <x-atoms.button type="primary">Cari Lapangan Baru</x-atoms.button>
                </a>
            @endif
        </div>

        @if(Auth::user()->role === 'admin' || isset($adminBookingsToday))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-200">
                <div class="p-6 sm:p-8 text-slate-900">
                    <h3 class="text-lg font-bold mb-4 border-b border-slate-100 pb-2">Ringkasan Pemesanan Admin</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-slate-700">Jumlah pemesanan per status</h4>
                            @if(isset($bookingsByStatus) && $bookingsByStatus->isNotEmpty())
                                <ul class="mt-3 space-y-2">
                                    @foreach($bookingsByStatus as $status => $total)
                                        <li class="flex justify-between border-b border-slate-100 py-2">
                                            <span class="capitalize text-slate-600">{{ $status }}</span>
                                            <span class="font-bold text-slate-900">{{ $total }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-500 mt-2">Tidak ada pemesanan.</p>
                            @endif
                        </div>

                        <div>
                            <h4 class="font-semibold text-slate-700">Pemesanan aktif terbaru</h4>
                            @if(isset($latestActiveBookings) && $latestActiveBookings->isNotEmpty())
                                <ul class="mt-3 space-y-3">
                                    @foreach($latestActiveBookings as $b)
                                        <li class="p-4 border border-slate-200 rounded-xl bg-slate-50">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="text-sm font-bold text-slate-800">{{ optional($b->field)->name ?? 'Lapangan' }}</div>
                                                    <div class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($b->booking_date)->format('Y-m-d') }} • <span class="capitalize">{{ $b->status }}</span></div>
                                                </div>
                                                <div class="text-sm font-black text-primary-600">Rp {{ number_format($b->total_price, 0, ',', '.') }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-500 mt-2">Tidak ada pemesanan aktif.</p>
                            @endif
                        </div>
                    </div>

                    @if(isset($adminBookingsToday))
                        <div class="mt-8 border-t border-slate-200 pt-6">
                            <h3 class="text-lg font-bold mb-2">Pemesanan Hari Ini</h3>
                            <p class="text-3xl font-black text-primary-600">{{ $adminBookingsToday }}</p>
                            <p class="text-sm text-slate-500 mt-1">Jumlah pemesanan yang terdaftar untuk venue yang Anda kelola hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            @php
                $pendingBookings = \App\Models\Booking::with('field.venue')
                    ->where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->latest()
                    ->get();

                $activeBookings = \App\Models\Booking::with('field.venue')
                    ->where('user_id', auth()->id())
                    ->whereIn('status', ['paid', 'confirmed'])
                    ->whereDate('booking_date', '>=', now()->toDateString())
                    ->latest()
                    ->get();
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    <div class="bg-amber-50 p-6 border-b border-amber-100 flex justify-between items-center">
                        <h2 class="font-extrabold text-amber-800 text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Menunggu Pembayaran
                        </h2>
                        <span class="bg-amber-200 text-amber-800 py-1 px-3 rounded-full text-xs font-black">{{ $pendingBookings->count() }}</span>
                    </div>

                    <div class="p-6 flex-1 bg-slate-50/50 space-y-4">
                        @forelse($pendingBookings as $booking)
                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-md uppercase tracking-wider">Menunggu Bayar</span>
                                    <span class="text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}</span>
                                </div>
                                <h3 class="font-bold text-slate-800 text-lg">{{ $booking->field->name }}</h3>
                                <p class="text-sm text-slate-500 mb-4">{{ $booking->field->venue->name ?? '' }} • {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                    <span class="font-black text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    <a href="{{ route('payments.show', $booking->id) }}">
                                        <x-atoms.button type="primary" class="!px-5 !py-2 !text-xs shadow-md">Lanjut Bayar</x-atoms.button>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-100 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h3 class="font-bold text-slate-700">Keranjang Kosong</h3>
                                <p class="text-sm text-slate-500 mt-1">Anda tidak memiliki tagihan yang belum dibayar.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    <div class="bg-emerald-50 p-6 border-b border-emerald-100 flex justify-between items-center">
                        <h2 class="font-extrabold text-emerald-800 text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Tiket Aktif Mendatang
                        </h2>
                        <span class="bg-emerald-200 text-emerald-800 py-1 px-3 rounded-full text-xs font-black">{{ $activeBookings->count() }}</span>
                    </div>

                    <div class="p-6 flex-1 bg-slate-50/50 space-y-4">
                        @forelse($activeBookings as $booking)
                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-2 h-full bg-emerald-500"></div>
                                <h3 class="font-bold text-slate-800 text-lg">{{ $booking->field->name }}</h3>
                                <p class="text-sm text-slate-500 mb-4">{{ $booking->field->venue->name ?? '' }} • {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d M Y') }}</p>

                                <div class="pt-4 border-t border-slate-100">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="block">
                                        <x-atoms.button type="secondary" class="w-full justify-center group-hover:bg-slate-800 group-hover:text-white transition-colors">Lihat E-Tiket</x-atoms.button>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-100 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                </div>
                                <h3 class="font-bold text-slate-700">Belum ada jadwal</h3>
                                <p class="text-sm text-slate-500 mt-1">Anda belum memiliki jadwal bermain yang aktif.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="mt-8 text-center bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-2">Ingin melihat pesanan sebelumnya?</h3>
                <p class="text-sm text-slate-500 mb-6">Semua riwayat pemesanan lapangan Anda yang sudah selesai atau dibatalkan tersimpan dengan aman.</p>
                <a href="{{ route('bookings.history') }}" class="inline-flex items-center justify-center bg-primary-50 text-primary-700 border border-primary-200 hover:bg-primary-600 hover:text-white transition-colors font-bold rounded-xl px-8 py-3.5 shadow-sm">
                    Lihat Semua Riwayat Transaksi &rarr;
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
