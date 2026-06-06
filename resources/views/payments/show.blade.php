<x-app-layout>
    <div x-data="paymentTimer('{{ $booking->expires_at->toIso8601String() }}')"
         class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-slate-50 border-b border-slate-200 p-6 md:p-8 text-center">
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Selesaikan Pembayaran</h1>
                <p class="text-slate-500 text-sm mb-6">Waktu Anda untuk mengunci jadwal lapangan terbatas.</p>

                <div class="inline-flex flex-col items-center justify-center bg-white border border-rose-100 rounded-2xl p-4 shadow-sm min-w-[200px]">
                    <span class="text-xs font-bold text-rose-500 uppercase tracking-widest mb-1">Sisa Waktu</span>
                    <div class="text-3xl font-black text-rose-600 tabular-nums tracking-tight">
                        <span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                    </div>
                </div>

                <p x-show="isExpired" x-cloak class="mt-4 text-sm font-bold text-rose-600 bg-rose-50 p-3 rounded-lg">
                    Waktu pembayaran telah habis. Memuat ulang halaman...
                </p>
            </div>

            <div class="p-6 md:p-8">
                <div class="flex justify-between items-center mb-6 pb-6 border-b border-slate-100">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Tempat</p>
                        <p class="text-lg font-bold text-slate-800">{{ $booking->field->name }}</p>
                        <p class="text-sm text-slate-500">{{ $booking->field->venue->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500 font-medium">Total Tagihan</p>
                        <p class="text-2xl font-black text-primary-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="font-bold text-blue-900 text-sm">Instruksi Pembayaran</h4>
                            <p class="text-sm text-blue-700 mt-1">Silakan transfer sesuai nominal di atas ke rekening Virtual Account berikut: <br><strong class="text-lg tracking-wider mt-2 block">0812-3456-7890</strong></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('payments.process', $booking) }}" method="POST">
                    @csrf
                    <button type="submit"
                            :disabled="isExpired"
                            class="w-full bg-primary-600 hover:bg-primary-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-lg font-bold py-4 px-6 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        Saya Sudah Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentTimer', (expiryDateStr) => ({
                expiryDate: new Date(expiryDateStr).getTime(),
                minutes: '00',
                seconds: '00',
                isExpired: false,
                interval: null,

                init() {
                    this.updateTimer();
                    this.interval = setInterval(() => this.updateTimer(), 1000);
                },

                updateTimer() {
                    const now = new Date().getTime();
                    const distance = this.expiryDate - now;

                    if (distance <= 0) {
                        clearInterval(this.interval);
                        this.isExpired = true;
                        this.minutes = '00';
                        this.seconds = '00';

                        // Otomatis refresh halaman agar backend mengeksekusi penghapusan DB
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                        return;
                    }

                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);

                    this.minutes = m < 10 ? '0' + m : m;
                    this.seconds = s < 10 ? '0' + s : s;
                }
            }))
        })
    </script>
</x-app-layout>
