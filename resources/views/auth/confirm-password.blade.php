<x-guest-layout>
    <div class="bg-white p-8 sm:p-12 rounded-[32px] shadow-xs border border-neutral-100 flex flex-col justify-center lg:col-span-2 max-w-xl mx-auto w-full">
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center gap-2 text-primary-600 mb-4 bg-primary-50 px-4 py-2 rounded-full">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest">Area Aman</span>
            </div>

            <h2 class="text-3xl font-extrabold tracking-tight text-accent-400 uppercase">Konfirmasi Sandi<span class="text-primary-400">.</span></h2>
            <p class="text-neutral-500 mt-2 leading-relaxed">
                {{ __('Harap konfirmasi kata sandi Anda sebelum melanjutkan ke bagian yang dilindungi ini.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <x-atoms.input-label for="password" :value="__('Kata Sandi')" />
                <x-atoms.input id="password"
                               class="rounded-2xl w-full"
                               type="password"
                               name="password"
                               required autocomplete="current-password" />
            </div>

            <div class="pt-4">
                <x-atoms.button type="primary" class="w-full">
                    {{ __('Konfirmasi') }}
                </x-atoms.button>
            </div>
        </form>
    </div>
</x-guest-layout>
