<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 text-center">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 text-center mt-1">Silakan masukkan detail Anda untuk mengakses arena.</p>
    </div>

    <!-- Session Status -->
    <x-molecules.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="email"
                          class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-atoms.input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="password"
                          class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-atoms.input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Route Button -->
        <div class="pt-2">
            <x-atoms.primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-3 rounded-lg text-base shadow-sm">
                {{ __('Log in') }}
            </x-atoms.primary-button>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-bold text-primary-600 hover:text-primary-700 transition-colors">
                    {{ __('Sign Up for Free') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
