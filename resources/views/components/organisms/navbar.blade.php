<div class="fixed mt-4 inset-x-0 z-50 px-4 h-16 sm:px-6 lg:px-8 flex justify-center">
    <nav x-data="{ open: false }" class="w-full max-w-7xl bg-primary-600 text-white rounded-full px-4 sm:px-6 py-2.5 flex items-center justify-between shadow-2xl relative transition-all duration-300">

        <div class="flex-1 flex items-center justify-start shrink-0">
            <a href="/" class="flex items-center gap-2 h-8">
                <x-atoms.application-logo color="white" class="block h-8 w-8" />
                <span class="text-lg font-bold text-white tracking-tight hidden lg:block">BookingLapangan</span>
            </a>
        </div>

        <div class="hidden md:flex items-center justify-center gap-2 lg:gap-4 shrink-0 px-4">

            <x-atoms.button href="/venues" variant="navbar" :active="request()->routeIs('venues.*') || request()->routeIs('home')" class="!px-4 !py-1.5 text-sm">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </x-slot>
                Sewa Lapangan
            </x-atoms.button>

            <x-atoms.button href="/partner" variant="navbar" :active="request()->routeIs('partner')" class="!px-4 !py-1.5 text-sm">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </x-slot>
                Partner with Us
            </x-atoms.button>

            @auth
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'super-admin')
                    <x-atoms.button href="{{ route('admin.dashboard') }}" variant="navbar" :active="request()->is('admin*')" class="!px-4 !py-1.5 text-sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </x-slot>
                        Panel Admin
                    </x-atoms.button>
                @else
                    <x-atoms.button href="{{ route('dashboard') }}" variant="navbar" :active="request()->routeIs('dashboard')" class="!px-4 !py-1.5 text-sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </x-slot>
                        <span class="relative pr-2">
                            Pembayaran
                            @if(auth()->check() && \App\Models\Booking::where('user_id', auth()->id())->whereIn('status', ['pending'])->exists())
                                <span class="absolute top-0 right-0 -mt-0.5 -mr-1.5 flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                </span>
                            @endif
                        </span>
                    </x-atoms.button>
                @endif
            @endauth
        </div>

        <div class="hidden md:flex flex-1 items-center justify-end space-x-3 shrink-0">
            @guest
                <a href="{{ route('register') }}">
                    <x-atoms.button type="primary" class="px-5 py-2 text-sm border border-primary-500">
                        Daftar
                    </x-atoms.button>
                </a>
                <a href="{{ route('login') }}">
                    <x-atoms.button type="secondary" class="px-5 py-2 text-sm border-none bg-white text-primary-600 hover:bg-neutral-100">
                        Masuk
                    </x-atoms.button>
                </a>
            @else
                <div class="flex items-center space-x-4">
                    <x-molecules.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="flex items-center gap-2 p-1 pr-2 rounded-full bg-primary-700/50 hover:bg-primary-700 border border-primary-500/50 focus:outline-none transition-colors">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-primary-600 font-bold text-sm shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-100 dark:border-neutral-700">
                                <p class="text-sm font-medium text-neutral-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'super-admin')
                                <x-molecules.dropdown-link :href="route('admin.dashboard')" class="dark:text-neutral-200 dark:hover:bg-neutral-700">
                                    {{ __('Panel Admin') }}
                                </x-molecules.dropdown-link>
                            @endif

                            <x-molecules.dropdown-link :href="route('profile.edit')" class="dark:text-neutral-200 dark:hover:bg-neutral-700">
                                {{ __('Profile') }}
                            </x-molecules.dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-molecules.dropdown-link :href="route('logout')"
                                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                                           class="text-danger-600 dark:text-danger-500 dark:hover:bg-neutral-700 font-medium">
                                    {{ __('Log Out') }}
                                </x-molecules.dropdown-link>
                            </form>
                        </x-slot>
                    </x-molecules.dropdown>
                </div>
            @endguest
        </div>

        <div class="flex-1 flex items-center justify-end md:hidden gap-2">

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

        {{-- DROPDOWN MENU MOBILE --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="absolute top-[calc(100%+0.75rem)] left-0 w-full bg-primary-600 rounded-2xl shadow-2xl overflow-hidden md:hidden z-50 py-2"
             style="display: none;"
             @click.outside="open = false"> <div class="px-3 space-y-2">
                <x-atoms.button href="/venues" variant="navbar" :active="request()->routeIs('venues') || request()->routeIs('home')" class="w-full justify-start !px-4 !py-3 text-sm">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </x-slot>
                    Sewa Lapangan
                </x-atoms.button>

                <x-atoms.button href="/partner" variant="navbar" :active="request()->routeIs('partner')" class="w-full justify-start !px-4 !py-3 text-sm">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </x-slot>
                    Partner with Us
                </x-atoms.button>

                @auth
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'super-admin')
                        <x-atoms.button href="{{ route('admin.dashboard') }}" variant="navbar" :active="request()->is('admin*')" class="w-full justify-start !px-4 !py-3 text-sm">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </x-slot>
                            Panel Admin
                        </x-atoms.button>
                    @else
                        <x-atoms.button href="{{ route('dashboard') }}" variant="navbar" :active="request()->routeIs('dashboard') || request()->routeIs('bookings.*')" class="w-full justify-start !px-4 !py-3 text-sm">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </x-slot>
                            <span class="relative pr-2">
                                Pembayaran
                                @if(auth()->check() && \App\Models\Booking::where('user_id', auth()->id())->whereIn('status', ['pending'])->exists())
                                    <span class="absolute top-0 right-0 -mt-0.5 -mr-1 flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                                    </span>
                                @endif
                            </span>
                        </x-atoms.button>
                    @endif
                @endauth
            </div>

            @guest
                <div class="mt-4 pt-4 border-t border-primary-500/50 px-4 pb-2 flex flex-col gap-3">
                    <a href="{{ route('register') }}" class="w-full">
                        <x-atoms.button type="primary" class="w-full justify-center border border-primary-500">Daftar</x-atoms.button>
                    </a>
                    <a href="{{ route('login') }}" class="w-full">
                        <x-atoms.button type="secondary" class="w-full justify-center border-none bg-white text-primary-600">Masuk</x-atoms.button>
                    </a>
                </div>
            @else
                <div class="mt-4 pt-4 border-t border-primary-500/50 px-2 pb-2">
                    <div class="px-4 mb-4">
                        <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-primary-100">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-lg text-sm font-medium text-primary-100 hover:bg-primary-700 hover:text-white">Profile Settings</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-3 rounded-lg text-sm font-medium text-danger-300 hover:bg-primary-700">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </nav>
</div>
