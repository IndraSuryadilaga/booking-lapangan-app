<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900">Buat Akun</h2>
        <p class="mt-1 text-sm text-gray-500">Bergabunglah dengan arena digital dan mulai pemesanan.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="name" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-atoms.input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="email" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-atoms.input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Phone (Optional) -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="phone" :value="__('Nomor Telepon (Opsional)')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="phone" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-atoms.input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="password" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password" required autocomplete="new-password" />
            <x-atoms.input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="password_confirmation" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-atoms.input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-atoms.button type="primary" class="w-full">
                {{ __('Daftar Sekarang') }}
            </x-atoms.button>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Sudah punya akun?") }}
                <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:text-primary-700 transition-colors">
                    {{ __('Masuk') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
