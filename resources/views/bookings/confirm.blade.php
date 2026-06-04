<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Konfirmasi Pesanan</h1>
            <p class="text-sm text-slate-500 mt-2">Periksa kembali detail jadwal lapanganmu sebelum membuat pesanan.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col md:flex-row">

            <div class="p-6 md:p-8 md:w-[45%] border-b md:border-b-0 md:border-r border-slate-200 bg-slate-50/50">
                <div class="relative w-full aspect-video rounded-xl overflow-hidden mb-6 bg-slate-200">
                    <img src="{{ $field->primary_image_url ?? 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=800&auto=format&fit=crop' }}"
                         alt="{{ $field->name }}"
                         class="w-full h-full object-cover">
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-1">{{ $field->name }}</h2>
                <p class="text-sm text-slate-500 font-medium mb-6">{{ $field->venue->name ?? 'Venue Center' }}</p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Tanggal Main</p>
                            <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($bookingData['booking_date'])->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 md:w-[55%] flex flex-col">
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-200 pb-2">Rincian Waktu Sesi</h3>

                <div class="flex-grow overflow-y-auto max-h-60 pr-2 scrollbar-thin scrollbar-thumb-slate-200">
                    <ul class="space-y-3">
                        @php $totalSemua = 0; @endphp

                        @foreach($bookingData['slots'] as $index => $slot)
                            @php
                                $time = $slot['time'];
                                $hargaSesi = $slot['price'];
                                $totalSemua += $hargaSesi;
                            @endphp
                            <li class="flex justify-between items-center p-3 sm:p-4 rounded-xl border border-slate-200 bg-white hover:border-primary-300 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                    <span class="font-bold text-slate-700 tracking-wide">
                                        {{ $time }} - {{ \Carbon\Carbon::parse($time)->addHour()->format('H:i') }}
                                    </span>
                                </div>
                                <span class="font-bold text-emerald-600">Rp {{ number_format($hargaSesi, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200 border-dashed">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Subtotal Pembayaran</p>
                            <p class="text-xs text-slate-400 mt-1">{{ count($bookingData['slots']) }} Sesi Terpilih</p>
                        </div>
                        <span class="text-3xl font-extrabold text-emerald-600 tracking-tight">
                            Rp {{ number_format($totalSemua, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($errors->any())
                        <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-xl mb-6">
                            <p class="font-bold mb-2">Gagal memproses pesanan:</p>
                            <ul class="list-disc pl-5 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-xl mb-6 text-sm font-medium">
                            Terjadi Kesalahan Sistem: {{ session('error') }}
                        </div>
                    @endif
                    <!-- Form HANYA membungkus tombol Buat Pesanan -->
                    <form action="{{ route('bookings.store') }}" method="POST" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                        @csrf
                        <input type="hidden" name="field_id" value="{{ $field->id }}">
                        <input type="hidden" name="booking_date" value="{{ $bookingData['booking_date'] }}">
                        <input type="hidden" name="total_price" value="{{ $totalSemua }}">

                        @foreach($bookingData['slots'] as $index => $slot)
                            <input type="hidden" name="slots[{{ $index }}][start_time]" value="{{ \Carbon\Carbon::parse($slot['time'])->format('H:i:s') }}">
                            <input type="hidden" name="slots[{{ $index }}][end_time]" value="{{ \Carbon\Carbon::parse($slot['time'])->addHour()->format('H:i:s') }}">
                            <input type="hidden" name="slots[{{ $index }}][price]" value="{{ $slot['price'] }}">
                        @endforeach

                        <div class="mt-8 flex flex-col gap-3">
                            <x-atoms.button
                                type="primary"
                                class="w-full text-lg py-4 shadow-[0_8px_20px_-6px_rgba(37,99,235,0.4)]"
                                x-bind:disabled="isSubmitting"
                            >
                                <span x-show="!isSubmitting" class="flex items-center gap-2">
                                    Buat Pesanan Sekarang
                                </span>
                                <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </x-atoms.button>
                        </div>
                    </form>

                    <!-- Tombol Batal DI LUAR tag form agar terbebas dari aksi submit -->
                    <div class="mt-3 flex flex-col gap-3">
                        <a href="{{ route('venues.show', $field->venue->slug) }}" class="w-full block">
                            <x-atoms.button
                                type="secondary"
                                class="w-full py-3"
                                onclick="window.location.href='{{ route('venues.show', $field->venue->slug) }}'; return false;"
                            >
                                Batal
                            </x-atoms.button>
                        </a>
                    </div>

                    <p class="text-center text-xs text-slate-400 mt-4">
                        Dengan buat pesanan, jadwal akan dikunci sementara.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
