<x-app-layout>
    {{-- Hero Section --}}
    <div class="bg-gradient-to-b from-slate-900 to-slate-950 text-white rounded-b-3xl overflow-hidden pt-36 pb-24 relative">        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-1/2 -right-1/2 w-[100%] aspect-square bg-gradient-to-b from-primary-400/30 to-transparent rounded-full blur-3xl transform rotate-12"></div>
            <div class="absolute -bottom-1/2 -left-1/2 w-[100%] aspect-square bg-gradient-to-t from-primary-800/50 to-transparent rounded-full blur-3xl transform -rotate-12"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-primary-800 text-primary-100 border border-primary-500/50 mb-6 shadow-inner">
                <svg class="w-4 h-4 text-warning-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Kemitraan BookingLapangan
            </span>
            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                Tingkatkan Pendapatan & <br class="hidden md:block" /> Okupansi Venue Anda
            </h1>
            <p class="text-lg md:text-xl text-primary-100 max-w-2xl mx-auto mb-10 leading-relaxed">
                Bergabunglah dengan jaringan venue olahraga terbesar. Kelola jadwal lebih mudah, otomatisasi pembayaran, dan jangkau ribuan pelanggan baru setiap harinya.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                {{-- Mengarahkan langsung ke pendaftaran venue --}}
                <x-atoms.button href="{{ route('admin.venues.create') }}">
                    Daftarkan Venue Sekarang
                </x-atoms.button>
                <x-atoms.button href="#benefits" variant="secondary">
                    Pelajari Lebih Lanjut
                </x-atoms.button>
            </div>
        </div>
    </div>

    {{-- Benefits Section --}}
    <div id="benefits" class="py-16 lg:py-24 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white mb-4">Mengapa Bermitra dengan Kami?</h2>
                <p class="text-neutral-500 dark:text-neutral-400">Kami menyediakan ekosistem digital lengkap untuk mengubah cara Anda mengelola bisnis lapangan olahraga.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-neutral-700 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mb-6 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">Tingkatkan Visibilitas</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">
                        Venue Anda akan muncul di hadapan ribuan pengguna aktif yang sedang mencari lapangan olahraga di sekitar kota Anda setiap harinya.
                    </p>
                </div>

                <div class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-neutral-700 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-6 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">Pembayaran Terjamin</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">
                        Sistem pembayaran kami menangani transaksi secara otomatis. Bebas dari masalah "booking fiktif" atau pelanggan yang tidak membayar.
                    </p>
                </div>

                <div class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-neutral-700 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6 text-blue-600 dark:text-blue-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">Manajemen Jadwal Pintar</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">
                        Tinggalkan buku catatan manual. Atur ketersediaan lapangan, tutup jadwal saat libur, dan atur harga dinamis dari satu dashboard interaktif.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Cara Mudah Memulai Section --}}
    <div class="py-16 lg:py-24 bg-white dark:bg-neutral-800 border-y border-slate-200 dark:border-neutral-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white text-center mb-16">Cara Mudah Memulai</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="hidden md:block absolute top-8 left-12 right-12 h-0.5 bg-slate-200 dark:bg-neutral-700 z-0"></div>

                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-primary-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 border-4 border-white dark:border-neutral-800 shadow-sm">1</div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Registrasi</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Buat akun dan daftarkan profil venue Anda secara gratis.</p>
                </div>

                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-white dark:bg-neutral-800 text-primary-600 dark:text-primary-400 border-4 border-primary-600 dark:border-primary-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm">2</div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Lengkapi Data</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Tambahkan daftar lapangan, foto, harga, dan jadwal operasional.</p>
                </div>

                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-white dark:bg-neutral-800 text-primary-600 dark:text-primary-400 border-4 border-primary-600 dark:border-primary-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm">3</div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Verifikasi</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Tim kami akan meninjau dan menyetujui profil venue Anda.</p>
                </div>

                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-emerald-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 border-4 border-white dark:border-neutral-800 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Mulai Menerima Booking</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Venue Anda live dan siap dipesan oleh pelanggan.</p>
                </div>
            </div>
        </div>
    </div>

    {{--
        =========================================================
        4. FAQ SECTION
        =========================================================
    --}}
    <div class="py-16 lg:py-24 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white text-center mb-12">Pertanyaan yang Sering Diajukan</h2>

            <div class="space-y-4">
                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Apakah ada biaya pendaftaran?</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Tidak ada. Pendaftaran venue sepenuhnya GRATIS. Kami hanya mengenakan biaya administrasi kecil dari setiap transaksi pemesanan yang berhasil melalui platform kami.</p>
                </div>

                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Kapan dana pemesanan dicairkan ke rekening saya?</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Pencairan dana (settlement) dilakukan secara otomatis setiap minggunya ke rekening bank yang telah Anda daftarkan di dashboard admin.</p>
                </div>

                <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Apakah saya masih bisa menerima pelanggan yang datang langsung (offline)?</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Tentu saja! Anda bisa dengan mudah menutup jadwal (block schedule) melalui dashboard admin jika ada pelanggan offline, sehingga tidak terjadi bentrok jadwal.</p>
                </div>
            </div>
        </div>
    </div>

    {{--
        =========================================================
        5. BOTTOM CTA SECTION
        =========================================================
    --}}
    <div class="py-20 bg-white dark:bg-neutral-800 text-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white mb-6">Siap Mengembangkan Bisnis Anda?</h2>
            <p class="text-lg text-neutral-500 dark:text-neutral-400 mb-10">
                Jangan lewatkan kesempatan untuk digitalisasi venue Anda. Proses cepat, mudah, dan didukung tim yang siap membantu Anda kapan saja.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('admin.venues.create') }}">
                    <x-atoms.button type="primary" class="!px-10 !py-4 text-lg shadow-lg">
                        Mulai Kemitraan Sekarang
                    </x-atoms.button>
                </a>
            </div>
            <p class="mt-8 text-sm text-neutral-400">Atau hubungi kami di <a href="mailto:partners@bookinglapangan.com" class="text-primary-600 font-semibold hover:underline">partners@bookinglapangan.com</a></p>
        </div>
    </div>
</x-app-layout>
