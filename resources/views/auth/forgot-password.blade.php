<x-guest-layout>
    <div class="bg-white p-8 sm:p-12 rounded-[32px] shadow-xs border border-neutral-100 flex flex-col justify-center lg:col-span-2 max-w-xl mx-auto w-full">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-accent-400">Reset Sandi<span class="text-primary-400">.</span></h2>
            <p class="text-neutral-500 mt-2">
                {{ __('Lupa kata sandi Anda? Masukkan alamat email Anda dan kami akan mengirimkan tautan reset.') }}
            </p>
        </div>

        <x-molecules.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <x-atoms.input-label for="email" :value="__('Alamat Email')" />
                <x-atoms.input
                    id="email"
                    type="email"
                    placeholder="atlet@email.com"
                    name="email"
                    :value="old('email')"
                    :error="$errors->has('email')"
                    required
                    autofocus
                    class="rounded-2xl w-full"
                />
            </div>

            <div class="pt-4">
                <x-atoms.button type="primary" class="w-full">
                    {{ __('Kirim Tautan Reset') }}
                </x-atoms.button>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-sm font-extrabold text-primary-500 hover:text-primary-700 hover:underline uppercase transition-colors">
                    {{ __('Kembali ke Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
