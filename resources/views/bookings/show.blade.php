<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8 pt-28">

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('bookings.history') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Riwayat
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

            <div class="bg-primary-600 p-8 text-white flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-black text-primary-100 uppercase">E-Tiket Masuk</h1>
                    <p class="text-primary-100 mt-1">Tunjukkan tiket ini kepada petugas lapangan</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-primary-200 font-medium uppercase tracking-widest">Kode Booking</p>
                    <p class="text-xl font-bold font-mono mt-1">{{ $booking->payment->reference_code ?? 'TBA-'.strtoupper(Str::random(6)) }}</p>
                </div>
            </div>

            <div class="p-8">
                <div class="flex flex-col sm:flex-row justify-between gap-6 border-b border-slate-200 pb-8">
                    <div class="w-full sm:w-1/2">
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">Lokasi Bermain</p>
                        <h2 class="text-xl font-bold text-slate-900">{{ $booking->field->venue->name ?? 'Venue Sport' }}</h2>
                        <p class="text-primary-600 font-semibold mt-1">{{ $booking->field->name }}</p>
                    </div>

                    <div class="w-full sm:w-1/2 sm:text-right">
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">Jadwal</p>
                        <p class="text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</p>
                        <div class="mt-2 inline-flex flex-wrap gap-2 justify-start sm:justify-end">
                            @foreach($booking->slots as $slot)
                                <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-md text-xs font-bold border border-slate-200">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-4">Rincian Transaksi</h3>
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Total Sesi</span>
                                <span class="font-bold text-slate-900">{{ $booking->total_slots }} Sesi (Jam)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Metode Pembayaran</span>
                                <span class="font-bold text-slate-900 capitalize">{{ str_replace('_', ' ', $booking->payment->method ?? 'Sistem') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Waktu Pembayaran</span>
                                <span class="font-bold text-slate-900">{{ $booking->payment ? \Carbon\Carbon::parse($booking->payment->paid_at)->translatedFormat('d M Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-200 border-dashed mt-3">
                                <span class="font-bold text-slate-900">Total Dibayar</span>
                                <span class="text-xl font-black text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    @if($booking->status === 'paid' || $booking->status === 'confirmed' || $booking->status === 'completed')
                        <div class="inline-block border-2 border-emerald-500 text-emerald-500 px-6 py-2 rounded-lg font-black text-lg tracking-widest uppercase transform -rotate-2 opacity-80">
                            LUNAS / VALID
                        </div>
                    @else
                        <div class="inline-block border-2 border-rose-500 text-rose-500 px-6 py-2 rounded-lg font-black text-lg tracking-widest uppercase transform -rotate-2 opacity-80">
                            {{ strtoupper($booking->status) }}
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
