@php
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
    $isSuperAdmin = $user && $user->role === 'super-admin';
@endphp

<div class="relative z-40 px-4 sm:px-6 lg:px-8 flex justify-center -mt-6 mb-8">
    <div class="w-full max-w-7xl bg-indigo-50 dark:bg-neutral-800 rounded-b-[2rem] pt-9 pb-3 px-4 sm:px-8 shadow-sm border border-t-0 border-indigo-100 dark:border-neutral-700">

        <nav class="flex items-center overflow-x-auto scrollbar-hide py-1 gap-2 sm:gap-3" style="scrollbar-width: none;">
            <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>

            <x-atoms.button href="{{ route('admin.dashboard') }}" variant="nav" :active="request()->routeIs('admin.dashboard')" class="!px-4 !py-2 text-sm shrink-0">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </x-slot>
                Dashboard
            </x-atoms.button>

            @if(($isAdmin || $isSuperAdmin) && $user->hasVenue())
                <x-atoms.button href="{{ route('admin.venues.my-venue') }}" variant="nav" :active="request()->routeIs('admin.venues.my-venue')" class="!px-4 !py-2 text-sm shrink-0">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </x-slot>
                    Venue Saya
                </x-atoms.button>
            @endif

            @if($isSuperAdmin)
                <x-atoms.button href="{{ route('admin.venues.index') }}" variant="nav" :active="request()->routeIs('admin.venues.*') && !request()->routeIs('admin.venues.my-venue')" class="!px-4 !py-2 text-sm shrink-0">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </x-slot>
                    Kelola Venue
                </x-atoms.button>
            @endif

            <x-atoms.button href="{{ route('admin.fields.index') }}" variant="nav" :active="request()->routeIs('admin.fields.*')" class="!px-4 !py-2 text-sm shrink-0">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </x-slot>
                Kelola Lapangan
            </x-atoms.button>

            <x-atoms.button href="{{ route('admin.bookings.index') }}" variant="nav" :active="request()->routeIs('admin.bookings.*')" class="!px-4 !py-2 text-sm shrink-0">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </x-slot>
                Kelola Booking
            </x-atoms.button>

            @if($isSuperAdmin)
                {{-- Garis Pemisah Visual --}}
                <div class="w-px h-5 bg-indigo-200 dark:bg-neutral-700 my-auto mx-1 shrink-0"></div>

                <x-atoms.button href="{{ route('sports-categories.index') }}" variant="nav" :active="request()->routeIs('sports-categories.*')" class="!px-4 !py-2 text-sm shrink-0">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </x-slot>
                    Kategori Olahraga
                </x-atoms.button>

                <x-atoms.button href="{{ route('facilities.index') }}" variant="nav" :active="request()->routeIs('facilities.*')" class="!px-4 !py-2 text-sm shrink-0">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </x-slot>
                    Fasilitas
                </x-atoms.button>

                <x-atoms.button href="{{ route('holidays.index') }}" variant="nav" :active="request()->routeIs('holidays.*')" class="!px-4 !py-2 text-sm shrink-0">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </x-slot>
                    Hari Libur
                </x-atoms.button>
            @endif

        </nav>
    </div>
</div>
