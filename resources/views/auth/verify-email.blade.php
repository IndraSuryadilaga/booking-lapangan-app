<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-900">Verifikasi Email Anda</h3>
        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
            Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email kepada Anda? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang lain.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 flex items-start gap-3 rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-800">
            <svg class="size-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><span class="font-semibold">Berhasil!</span> Tautan verifikasi baru telah dikirim ke email Anda.</p>
        </div>
    @endif

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf

            <x-primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-2.5 rounded-lg">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
