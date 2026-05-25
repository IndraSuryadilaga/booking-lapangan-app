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
            <x-atoms.input id="name" type="text" name="name" :value="old('name')" placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-atoms.input id="email" type="email" name="email" :value="old('email')" placeholder="contoh@email.com" required autocomplete="username" />
        </div>

        <!-- Phone (Optional) -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="phone" :value="__('Nomor Telepon (Opsional)')" class="font-semibold text-gray-700" />
            <x-atoms.input id="phone" type="text" name="phone" :value="old('phone')" placeholder="0812xxxxxxxx" autocomplete="tel" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />
            <x-atoms.input id="password" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-semibold text-gray-700" />
            <x-atoms.input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
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
