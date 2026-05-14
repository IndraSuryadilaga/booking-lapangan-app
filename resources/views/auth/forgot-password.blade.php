<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-900">Reset Password</h3>
        <div class="mt-2 text-sm text-gray-600 leading-relaxed">
            {{ __('Forgot your password? No problem. Enter your email address and we will send a reset link to your inbox.') }}
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold text-gray-700" />
            <x-text-input id="email"
                          class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150"
                          type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Route Button -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-2.5 rounded-lg">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>

        <!-- Route Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                ← Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
