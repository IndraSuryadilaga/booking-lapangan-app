<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900">{{ __('Create Account') }}</h2>
        <p class="mt-1 text-sm text-gray-500">{{ __('Join the digital arena and start booking.') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-input-label for="name" :value="__('Full Name')" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold text-gray-700" />
            <x-text-input id="password_confirmation" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2 flex flex-col gap-4">
            <x-primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-3 rounded-lg text-sm font-bold shadow-sm">
                {{ __('Register Now') }}
            </x-primary-button>

            <div class="text-center">
                <a class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors" href="{{ route('login') }}">
                    {{ __('Already have an account? Log in') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
