<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 text-center">{{ __('Reset Kata Sandi') }}</h2>
        <p class="text-sm text-gray-500 text-center mt-1">
            {{ __('Lupa kata sandi Anda? Masukkan alamat email Anda dan kami akan mengirimkan tautan reset.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-molecules.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-atoms.input
                id="email"
                type="email"
                placeholder="nama@email.com"
                name="email"
                :value="old('email')"
                :error="$errors->has('email')"
                required
                autofocus
            />
        </div>

        <div class="pt-8">
            <x-atoms.button type="primary" class="w-full">
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </x-atoms.button>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <a href="{{ route('login') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">
                {{ __('Kembali ke Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
