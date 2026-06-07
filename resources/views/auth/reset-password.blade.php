<x-guest-layout>
    <div class="bg-white p-8 sm:p-12 rounded-[32px] shadow-xs border border-neutral-100 flex flex-col justify-center lg:col-span-2 max-w-xl mx-auto w-full">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-accent-400 uppercase">Sandi Baru<span class="text-primary-400">.</span></h2>
            <p class="text-neutral-500 mt-2">Pastikan kata sandi baru Anda aman dan mudah diingat.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-1.5">
                <x-atoms.input-label for="email" :value="__('Email')" />
                <x-atoms.input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" class="rounded-2xl w-full" />
            </div>

            <div class="space-y-1.5">
                <x-atoms.input-label for="password" :value="__('Kata Sandi Baru')" />
                <x-atoms.input id="password" type="password" name="password" required autocomplete="new-password" class="rounded-2xl w-full" />
            </div>

            <div class="space-y-1.5">
                <x-atoms.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                <x-atoms.input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="rounded-2xl w-full" />
            </div>

            <div class="pt-4">
                <x-atoms.button type="primary" class="w-full">
                    {{ __('Simpan Kata Sandi') }}
                </x-atoms.button>
            </div>
        </form>
    </div>
</x-guest-layout>
