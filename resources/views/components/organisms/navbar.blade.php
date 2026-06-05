<div class="relative mt-4 inset-x-0 z-50 px-4 h-16 sm:px-6 lg:px-8 flex justify-center">
    <nav x-data="{ open: false }" class="w-full max-w-7xl bg-primary-600 text-white rounded-full px-4 sm:px-6 py-2.5 flex items-center justify-between shadow-2xl relative transition-all duration-300">

        <div class="flex h-8 items-center shrink-0">
            <a href="/" class="h-full">
                <x-atoms.application-logo color="white" class="block h-8 w-8" />
            </a>
        </div>

        <div class="hidden md:flex items-center justify-center space-x-8 flex-1 px-4">
            {{-- Menu tampil untuk Guest ATAU User biasa (Bukan Admin) --}}
            @if (Auth::guest() || (Auth::check() && Auth::user()->role !== 'admin'))
                <a href="/catalog" class="text-sm font-medium transition-colors {{ request()->routeIs('catalog') || request()->routeIs('home') ? 'text-white font-semibold' : 'text-primary-100 hover:text-white' }}">
                    Sewa Lapangan
                </a>
                <a href="/mabar" class="text-sm font-medium transition-colors {{ request()->routeIs('mabar') ? 'text-white font-semibold' : 'text-primary-100 hover:text-white' }}">
                    Main Bareng
                </a>
                <a href="/partner" class="text-sm font-medium transition-colors {{ request()->routeIs('partner') ? 'text-white font-semibold' : 'text-primary-100 hover:text-white' }}">
                    Partner with Us
                </a>
            @endif
        </div>

        <div class="hidden md:flex items-center h-8 space-x-3 shrink-0">
            @guest
                <a href="{{ route('register') }}">
                    <x-atoms.button type="primary" class="px-5 py-2 text-sm">
                        Daftar
                    </x-atoms.button>
                </a>
                <a href="{{ route('login') }}">
                    <x-atoms.button type="secondary" class="px-5 py-2 text-sm">
                        Masuk
                    </x-atoms.button>
                </a>
            @else
                <div class="flex items-center space-x-5">
                    @if (Auth::user()->role === 'admin')
                        <a href="/admin" class="text-sm font-semibold text-primary-400 hover:text-primary-300 transition-colors">Panel Admin</a>
                    @endif

                        <a href="/dashboard" class="relative p-1 text-primary-100 hover:text-white transition-colors focus:outline-none">
                            <span class="sr-only">Buka Aktivitas</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>

                            @if(auth()->check() && (\App\Models\Booking::where('user_id', auth()->id())->whereIn('status', ['pending', 'paid', 'confirmed'])->exists()))
                                <span class="absolute top-0 right-0 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                            </span>
                            @endif
                        </a>
                    <x-molecules.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <x-atoms.button type="secondary" class="flex items-center gap-2 !px-1.5 !py-1.5 rounded-full focus:outline-none">
                                <div class="w-7 h-7 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="fill-current h-4 w-4 text-primary-100 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </x-atoms.button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white dark:bg-primary-800">
                                <x-molecules.dropdown-link :href="route('profile.edit')" class="dark:text-primary-200 dark:hover:bg-primary-700">
                                    {{ __('Profile') }}
                                </x-molecules.dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-molecules.dropdown-link :href="route('logout')"
                                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                                               class="text-danger-500 dark:hover:bg-primary-700">
                                        {{ __('Log Out') }}
                                    </x-molecules.dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-molecules.dropdown>
                </div>
            @endguest
        </div>

        <div class="-mr-1 flex items-center md:hidden gap-2">

            @auth
                <button type="button" @click="$dispatch('open-sidebar')" class="relative inline-flex items-center justify-center p-2 rounded-full text-primary-100 hover:text-white hover:bg-primary-700 focus:outline-none transition-colors">
                    <span class="sr-only">Buka Aktivitas</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>

                    @if(\App\Models\Booking::where('user_id', auth()->id())->whereIn('status', ['pending', 'paid', 'confirmed'])->exists())
                        <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                    </span>
                    @endif
                </button>
            @endauth

            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-primary-100 hover:text-white hover:bg-primary-700 focus:outline-none transition-colors">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="absolute top-[calc(100%+0.75rem)] left-0 w-full bg-primary-600 rounded-2xl shadow-2xl overflow-hidden md:hidden z-50 py-2"
             style="display: none;">

            <div class="px-2 space-y-1">
                @if (Auth::guest() || (Auth::check() && Auth::user()->role !== 'admin'))
                    <a href="/catalog" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('catalog') || request()->routeIs('home') ? 'bg-primary-800 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">Sewa Lapangan</a>
                    <a href="/mabar" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('mabar') ? 'bg-primary-800 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">Main Bareng</a>
                    <a href="/partner" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('partner') ? 'bg-primary-800 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }}">Partner with Us</a>
                @endif
            </div>

            @guest
                <div class="mt-4 pt-4 border-t border-primary-200 px-4 pb-4 flex flex-col gap-3">
                    <a href="{{ route('register') }}" class="w-full">
                        <x-atoms.button type="primary" class="w-full">Daftar</x-atoms.button>
                    </a>
                    <a href="{{ route('login') }}" class="w-full">
                        <x-atoms.button type="secondary" class="w-full">Masuk</x-atoms.button>
                    </a>
                </div>
            @else
                <div class="mt-2 pt-4 border-t border-primary-200 px-2 pb-2">
                    <div class="px-4 mb-4">
                        <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-primary-100">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="space-y-1">
                        @if (Auth::user()->role === 'admin')
                            <a href="/admin" class="block px-4 py-3 rounded-lg text-sm font-medium text-primary-400 hover:bg-primary-700">Panel Admin</a>
                        @else
                            <a href="/dashboard/bookings" class="block px-4 py-3 rounded-lg text-sm font-medium text-primary-100 hover:bg-primary-700 hover:text-white">Pembayaran</a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-lg text-sm font-medium text-primary-100 hover:bg-primary-700 hover:text-white">Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-3 rounded-lg text-sm font-medium text-danger-400 hover:bg-primary-700">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </nav>
</div>
