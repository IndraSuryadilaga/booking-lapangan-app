<x-guest-layout>
    <div class="bg-white p-8 sm:p-12 rounded-[32px] shadow-xs border border-neutral-100 flex flex-col justify-center order-2 lg:order-1">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-accent-400 uppercase">Selamat Datang<span class="text-primary-400">.</span></h1>
            <p class="text-neutral-500 mt-2">Masuk ke arena digital dan mulai sesi olahragamu.</p>
        </div>

        <x-molecules.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div class="space-y-1.5">
                <x-atoms.input-label for="email" :value="__('Email')"/>
                <x-atoms.input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="atlet@email.com" class="rounded-2xl" />
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <x-atoms.input-label for="password" :value="__('Password')"/>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-primary-500 hover:text-primary-700" href="{{ route('password.request') }}">Lupa?</a>
                    @endif
                </div>
                <x-atoms.input id="password" type="password" name="password" required class="rounded-2xl" />
            </div>

            <div class="flex items-center">
                <x-atoms.select-checkbox id="remember_me" name="remember" :label="__('Ingat Sesi Saya')" />
            </div>

            <div class="pt-4">
                <x-atoms.button type="primary" class="w-full">
                    {{ __('Masuk') }}
                </x-atoms.button>
            </div>
        </form>

        <div class="mt-10 text-center">
            <p class="text-sm text-neutral-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-extrabold text-primary-500 hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>

    <div class="relative min-h-[400px] lg:min-h-full rounded-[32px] overflow-hidden order-1 lg:order-2 group">
        <img src="https://plus.unsplash.com/premium_photo-1707423388927-a281ca027069?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&fit=crop"
             alt="Sport Background"
             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700">

        <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-900/40 to-transparent"></div>

        <div class="absolute bottom-12 left-12 right-12">
            <h2 class="text-4xl sm:text-5xl font-black text-white leading-tight mb-4">Pesan Lapangan<br>Dalam <span class="px-2 text-4xl/[1.75] items-center text-accent-200 bg-white/10 backdrop-blur-md border border-white/20">Genggaman.</span></h2>
            <p class="text-primary-100 text-lg opacity-90 max-w-md">Keringatmu adalah kebanggaan kami. Mulai petualangan olahragamu di sini.</p>
        </div>
    </div>
</x-guest-layout>
