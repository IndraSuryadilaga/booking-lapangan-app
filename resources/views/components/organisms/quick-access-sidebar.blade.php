{{--<div--}}
{{--    x-data="{--}}
{{--        isOpen: false,--}}
{{--        activeTab: 'pending',--}}
{{--        init() {--}}
{{--            // Menerima sinyal otomatis dari backend (trigger dari PaymentController)--}}
{{--            if('{{ session('trigger_sidebar') }}') {--}}
{{--                this.isOpen = true;--}}
{{--                this.activeTab = 'active'; // Langsung buka tab tiket karena baru selesai bayar--}}
{{--            }--}}
{{--        }--}}
{{--    }"--}}
{{--    @open-sidebar.window="isOpen = true"--}}
{{--    @keydown.escape.window="isOpen = false"--}}
{{--    class="relative z-50"--}}
{{--    aria-labelledby="slide-over-title"--}}
{{--    role="dialog"--}}
{{--    aria-modal="true"--}}
{{--    x-cloak--}}
{{-->--}}
{{--    <div--}}
{{--        x-show="isOpen"--}}
{{--        x-transition:enter="ease-in-out duration-300"--}}
{{--        x-transition:enter-start="opacity-0"--}}
{{--        x-transition:enter-end="opacity-100"--}}
{{--        x-transition:leave="ease-in-out duration-300"--}}
{{--        x-transition:leave-start="opacity-100"--}}
{{--        x-transition:leave-end="opacity-0"--}}
{{--        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"--}}
{{--        @click="isOpen = false"--}}
{{--    ></div>--}}

{{--    <div class="fixed inset-0 overflow-hidden pointer-events-none">--}}
{{--        <div class="absolute inset-0 overflow-hidden">--}}
{{--            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">--}}
{{--                <div--}}
{{--                    x-show="isOpen"--}}
{{--                    x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400"--}}
{{--                    x-transition:enter-start="translate-x-full"--}}
{{--                    x-transition:enter-end="translate-x-0"--}}
{{--                    x-transition:leave="transform transition ease-in-out duration-300 sm:duration-400"--}}
{{--                    x-transition:leave-start="translate-x-0"--}}
{{--                    x-transition:leave-end="translate-x-full"--}}
{{--                    class="pointer-events-auto w-screen max-w-md"--}}
{{--                >--}}
{{--                    <div class="flex h-full flex-col bg-white shadow-2xl">--}}

{{--                        <div class="px-6 py-6 border-b border-slate-200">--}}
{{--                            <div class="flex items-center justify-between">--}}
{{--                                <h2 class="text-xl font-extrabold text-slate-900" id="slide-over-title">Aktivitas Saya</h2>--}}
{{--                                <button @click="isOpen = false" type="button" class="rounded-full p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none">--}}
{{--                                    <span class="sr-only">Close panel</span>--}}
{{--                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                            </div>--}}

{{--                            <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl mt-6">--}}
{{--                                <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="w-1/2 py-2 text-sm font-bold rounded-lg transition-all">--}}
{{--                                    Keranjang ({{ $pendingBookings->count() }})--}}
{{--                                </button>--}}
{{--                                <button @click="activeTab = 'active'" :class="activeTab === 'active' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="w-1/2 py-2 text-sm font-bold rounded-lg transition-all">--}}
{{--                                    Tiket Aktif ({{ $activeBookings->count() }})--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="flex-1 overflow-y-auto px-6 py-6 bg-slate-50/50">--}}

{{--                            <div x-show="activeTab === 'pending'" class="space-y-4">--}}
{{--                                @forelse($pendingBookings as $booking)--}}
{{--                                    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm">--}}
{{--                                        <div class="flex justify-between items-start mb-2">--}}
{{--                                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">Menunggu Pembayaran</span>--}}
{{--                                            <span class="text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}</span>--}}
{{--                                        </div>--}}
{{--                                        <h3 class="font-bold text-slate-800">{{ $booking->field->name }}</h3>--}}
{{--                                        <p class="text-xs text-slate-500 mb-3">{{ $booking->field->venue->name ?? '' }} • {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>--}}

{{--                                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">--}}
{{--                                            <span class="font-bold text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>--}}
{{--                                            <a href="{{ route('payments.show', $booking->id) }}">--}}
{{--                                                <x-atoms.button type="primary" class="!px-4 !py-2 !text-xs">Lanjut Bayar</x-atoms.button>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @empty--}}
{{--                                    <div class="text-center py-10">--}}
{{--                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>--}}
{{--                                        <p class="text-sm font-medium text-slate-500">Keranjang pesananmu kosong.</p>--}}
{{--                                    </div>--}}
{{--                                @endforelse--}}
{{--                            </div>--}}

{{--                            <div x-show="activeTab === 'active'" class="space-y-4" x-cloak>--}}
{{--                                @forelse($activeBookings as $booking)--}}
{{--                                    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm relative overflow-hidden">--}}
{{--                                        <div class="absolute top-0 right-0 w-2 h-full bg-emerald-500"></div>--}}
{{--                                        <h3 class="font-bold text-slate-800">{{ $booking->field->name }}</h3>--}}
{{--                                        <p class="text-xs text-slate-500 mb-3">{{ $booking->field->venue->name ?? '' }} • {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>--}}

{{--                                        <div class="mt-4 pt-4 border-t border-slate-100">--}}
{{--                                            <a href="{{ route('bookings.show', $booking->id) }}">--}}
{{--                                                <x-atoms.button type="secondary" class="w-full justify-center !py-2 !text-sm">Lihat E-Tiket</x-atoms.button>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @empty--}}
{{--                                    <div class="text-center py-10">--}}
{{--                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg></div>--}}
{{--                                        <p class="text-sm font-medium text-slate-500">Belum ada tiket aktif saat ini.</p>--}}
{{--                                    </div>--}}
{{--                                @endforelse--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="p-6 border-t border-slate-200 bg-white">--}}
{{--                            <a href="{{ route('bookings.history') }}" class="block text-center text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">--}}
{{--                                Lihat Semua Riwayat Transaksi →--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
