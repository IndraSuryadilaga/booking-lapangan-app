<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-neutral-900">Konfirmasi Pemesanan</h1>
                <p class="text-sm text-neutral-500 mt-1">Silakan periksa detail pesanan Anda sebelum melanjutkan ke pembayaran.</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $field = \App\Models\Field::with('venue')->find($bookingData['field_id']);
            @endphp

            <div class="border-t border-slate-100 pt-6 space-y-4">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm font-medium text-neutral-500">Venue</span>
                    <span class="text-sm font-semibold text-neutral-950">{{ $field->venue->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm font-medium text-neutral-500">Lapangan</span>
                    <span class="text-sm font-semibold text-neutral-950">{{ $field->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm font-medium text-neutral-500">Tanggal</span>
                    <span class="text-sm font-semibold text-neutral-950">{{ \Carbon\Carbon::parse($bookingData['booking_date'])->translatedFormat('d F Y') }}</span>
                </div>
                <div class="space-y-2">
                    <span class="text-sm font-medium text-neutral-500">Slot Waktu Pilihan:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($bookingData['slots'] as $slot)
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex justify-between items-center">
                                <span class="text-xs font-semibold text-neutral-700">
                                    {{ substr($slot['start_time'], 0, 5) }} - {{ substr($slot['end_time'], 0, 5) }}
                                </span>
                                <span class="text-xs font-bold text-neutral-950">
                                    Rp {{ number_format($slot['price'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6 flex justify-between items-center">
                <div>
                    <span class="text-sm font-medium text-neutral-500">Total Pembayaran</span>
                    <div class="text-2xl font-extrabold text-primary-600">
                        Rp {{ number_format($bookingData['total_price'], 0, ',', '.') }}
                    </div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="field_id" value="{{ $bookingData['field_id'] }}">
                    <input type="hidden" name="booking_date" value="{{ $bookingData['booking_date'] }}">
                    <input type="hidden" name="total_price" value="{{ $bookingData['total_price'] }}">
                    @foreach($bookingData['slots'] as $index => $slot)
                        <input type="hidden" name="slots[{{ $index }}][start_time]" value="{{ $slot['start_time'] }}">
                        <input type="hidden" name="slots[{{ $index }}][end_time]" value="{{ $slot['end_time'] }}">
                        <input type="hidden" name="slots[{{ $index }}][price]" value="{{ $slot['price'] }}">
                    @endforeach

                    <div class="flex gap-3">
                        <a href="{{ route('fields.show', $field->slug) }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <x-atoms.button type="primary" class="px-6 py-2.5">
                            Konfirmasi & Bayar
                        </x-atoms.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
