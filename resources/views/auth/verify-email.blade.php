<x-guest-layout>
    <div class="bg-white p-8 sm:p-12 rounded-[32px] shadow-xs border border-neutral-100 flex flex-col justify-center lg:col-span-2 max-w-2xl mx-auto w-full">
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-extrabold tracking-tight text-accent-400 uppercase">Verifikasi Email<span class="text-primary-400">.</span></h3>
            <p class="text-neutral-500 mt-4 leading-relaxed">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami akan mengirimkan yang lain.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-8 flex items-start gap-3 rounded-2xl bg-success-50 border border-success-200 p-4 text-sm text-success-700">
                <svg class="size-5 shrink-0 text-success-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p><span class="font-bold">Berhasil!</span> Tautan verifikasi baru telah dikirim ke email Anda.</p>
            </div>
        @endif

        <div class="mt-2 flex flex-col sm:flex-row items-center justify-between gap-6">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <x-atoms.button type="primary" class="w-full sm:w-auto">
                    {{ __('Kirim Ulang Email') }}
                </x-atoms.button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
                @csrf
                <button type="submit" class="text-sm font-extrabold text-neutral-500 hover:text-primary-600 hover:underline uppercase transition-colors">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
