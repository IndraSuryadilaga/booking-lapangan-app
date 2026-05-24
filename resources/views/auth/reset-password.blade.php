<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Atur Kata Sandi Baru</h2>
        <p class="mt-1 text-sm text-gray-500">Pastikan kata sandi baru Anda aman.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="email" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-atoms.input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="password" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password" required autocomplete="new-password" />
            <x-atoms.input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-atoms.text-input id="password_confirmation" class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-atoms.input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-atoms.primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700 py-3 rounded-lg font-bold">
                Atur Ulang Kata Sandi
            </x-atoms.primary-button>
        </div>
    </form>
</x-guest-layout>
