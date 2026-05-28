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
            <x-atoms.input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-atoms.input id="password" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-atoms.input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="pt-2">
            <x-atoms.button type="primary">
                {{ __('Atur Ulang Kata Sandi') }}
            </x-atoms.button>
        </div>
    </form>
</x-guest-layout>
