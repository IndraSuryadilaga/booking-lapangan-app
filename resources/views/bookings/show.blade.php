<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-emerald-50 border-b border-emerald-100 p-6 md:p-8 text-center">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-slate-500 text-sm">Pesanan Anda telah dikonfirmasi dan jadwal telah dikunci.</p>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-b pb-2">Detail Pesanan</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Status</span>
                        <span class="font-bold text-emerald-600 uppercase">{{ $booking->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tempat</span>
                        <span class="font-bold text-slate-800">{{ $booking->field->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal Main</span>
                        <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Harga</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ route('dashboard') }}">
                        <x-atoms.button type="primary">Kembali ke Beranda</x-atoms.button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout><x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-600 p-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-emerald-50 border-b border-emerald-100 p-6 md:p-8 text-center">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-slate-500 text-sm">Pesanan Anda telah dikonfirmasi dan jadwal telah dikunci.</p>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-b border-slate-200 pb-2">Detail Pesanan</h3>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Status</span>
                        <span class="font-bold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full text-xs uppercase tracking-wider">
                            {{ $booking->status }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Tempat</span>
                        <div class="text-right">
                            <span class="font-bold text-slate-800 block">{{ $booking->field->name }}</span>
                            <span class="text-xs text-slate-500">{{ $booking->field->venue->name ?? '' }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Tanggal Main</span>
                        <span class="font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center border-t border-slate-100 pt-4 mt-2">
                        <span class="text-slate-500 font-medium">Total Pembayaran</span>
                        <span class="font-black text-2xl text-primary-700">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-8 flex justify-center pt-6 border-t border-slate-200 border-dashed">
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto block">
                        <x-atoms.button type="primary" class="w-full justify-center">
                            Kembali ke Beranda
                        </x-atoms.button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
