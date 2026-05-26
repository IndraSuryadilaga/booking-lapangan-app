<x-guest-layout>
    <div class="mb-6">
        <div class="flex items-center gap-2 text-primary-700 mb-2">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Area Aman</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ __('Harap konfirmasi kata sandi Anda sebelum melanjutkan ke bagian yang dilindungi ini.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="space-y-1.5">
            <x-atoms.input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />
            <x-atoms.input id="password"
                          class="block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200 transition duration-150"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
        </div>

        <!-- Route Button -->
        <div class="pt-2 mt-6">
            <x-atoms.button type="primary" class="w-full">
                {{ __('Konfirmasi Kata Sandi') }}
            </x-atoms.button>
        </div>
    </form>
</x-guest-layout>
