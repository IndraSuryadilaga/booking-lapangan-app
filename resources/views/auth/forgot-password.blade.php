<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-900">Reset Kata Sandi</h3>
        <div class="mt-2 text-sm text-gray-600 leading-relaxed">
            {{ __('Lupa kata sandi Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan reset ke kotak masuk Anda.') }}
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="email"
                          class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150"
                          type="email" name="email" :value="old('email')" required autofocus />
            <x-atoms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Route Button -->
        <div class="flex items-center justify-end mt-6">
            <x-atoms.primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-2.5 rounded-lg">
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </x-atoms.primary-button>
        </div>

        <!-- Route Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                ← Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
