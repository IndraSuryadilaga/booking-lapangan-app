@php
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
    $isSuperAdmin = $user && $user->role === 'super-admin';
@endphp

<div class="w-full bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl shadow-sm p-4 sticky top-24 space-y-6">
    <div class="px-3 py-2 border-b border-slate-100 dark:border-neutral-700">
        <h2 class="text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">
            Menu Utama
        </h2>
    </div>

    <nav class="space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- My Venue (Venue Admin Only) -->
        @if($isAdmin && $user->hasVenue())
            <a href="{{ route('admin.venues.my-venue') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.venues.my-venue') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Venue Saya</span>
            </a>
        @endif

        <!-- Venue Management (Super Admin Only) -->
        @if($isSuperAdmin)
            <a href="{{ route('admin.venues.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.venues.*') && !request()->routeIs('admin.venues.my-venue') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Kelola Venue</span>
            </a>
        @endif

        <!-- Field Management -->
        <a href="{{ route('admin.fields.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.fields.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span>Kelola Lapangan</span>
        </a>

        <!-- Booking Management -->
        <a href="{{ route('admin.bookings.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Kelola Booking</span>
        </a>
    </nav>

    <!-- Master Data Section (Super Admin Only) -->
    @if($isSuperAdmin)
        <div class="pt-4 border-t border-slate-100 dark:border-neutral-700 space-y-4">
            <div class="px-3">
                <h2 class="text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">
                    Data Master
                </h2>
            </div>
            
            <nav class="space-y-1">
                <!-- Categories -->
                <a href="{{ route('sports-categories.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('sports-categories.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span>Kategori Olahraga</span>
                </a>

                <!-- Facilities -->
                <a href="{{ route('facilities.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('facilities.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span>Fasilitas</span>
                </a>

                <!-- Holidays -->
                <a href="{{ route('holidays.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('holidays.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400 font-semibold' : 'text-neutral-600 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-700/50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Hari Libur Nasional</span>
                </a>
            </nav>
        </div>
    @endif
</div>
