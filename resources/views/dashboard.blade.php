<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @auth
                        <p>{{ __('Anda sudah masuk.') }}</p>
                    @else
                        <p>{{ __('Anda melihat dashboard sebagai tamu. Masuk atau daftar untuk memesan lapangan.') }}</p>
                    @endauth

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('booking.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Pesan lapangan') }}
                        </a>
                        @guest
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                {{ __('Masuk') }}
                            </a>
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                {{ __('Daftar') }}
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
