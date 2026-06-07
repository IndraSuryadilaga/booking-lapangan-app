<x-app-layout>
    <div class="py-12 bg-neutral-50 min-h-screen pt-28">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex items-center gap-4">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white border border-neutral-200 text-neutral-500 hover:text-neutral-800 hover:border-neutral-300 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-extrabold text-neutral-800 tracking-tight">Edit <span class="text-primary-500">Profil</span></h2>
                    <p class="text-neutral-500 mt-1">Perbarui informasi pribadi dan keamanan akun Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Sidebar --}}
                <div class="lg:col-span-4 px-4 sm:px-0">
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-neutral-100 text-center sticky top-8">
                        <div class="w-24 h-24 mx-auto rounded-[24px] bg-primary-100 flex items-center justify-center text-4xl font-black text-primary-600 mb-5 shadow-inner">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <h3 class="text-xl font-extrabold text-neutral-800">{{ $user->name }}</h3>
                        <p class="text-sm font-medium text-neutral-500 mt-1">{{ $user->email }}</p>

                        <div class="mt-6 pt-6 border-t border-neutral-100">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase bg-success-50 text-success-600 border border-success-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></span>
                                Akun Aktif
                            </span>
                        </div>

                        {{-- Nav antar section --}}
                        <nav class="mt-6 pt-6 border-t border-neutral-100 flex flex-col gap-2 text-left">
                            <a href="#info" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-semibold text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Informasi Pribadi
                            </a>
                            <a href="#password" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-semibold text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                Keamanan Sandi
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-8 px-4 sm:px-0">

                    {{-- Informasi Pribadi --}}
                    <div id="info" class="bg-white rounded-[32px] p-8 sm:p-10 shadow-sm border border-neutral-100 scroll-mt-8">
                        <header class="mb-6">
                            <h2 class="text-xl font-extrabold text-neutral-800 uppercase tracking-tight">Informasi Pribadi</h2>
                            <p class="mt-1 text-sm text-neutral-500">Perbarui informasi profil dan alamat email akun Anda.</p>
                        </header>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div class="space-y-1.5">
                                <x-atoms.input-label for="name" :value="__('Nama Lengkap')" />
                                <x-atoms.input id="name" name="name" type="text" class="w-full rounded-2xl"
                                               :value="old('name', $user->name)"
                                               :error="$errors->has('name')"
                                               :messages="$errors->get('name')"
                                               required autofocus autocomplete="name" />
                            </div>

                            <div class="space-y-1.5">
                                <x-atoms.input-label for="email" :value="__('Alamat Email')" />
                                <x-atoms.input id="email" name="email" type="email" class="w-full rounded-2xl"
                                               :value="old('email', $user->email)"
                                               :error="$errors->has('email')"
                                               :messages="$errors->get('email')"
                                               required autocomplete="username" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 bg-warning-50 border border-warning-200 p-4 rounded-2xl">
                                        <p class="text-sm text-warning-800">
                                            Email Anda belum diverifikasi.
                                            <button form="send-verification" class="font-bold text-warning-900 hover:text-warning-700 underline focus:outline-none">
                                                Klik di sini untuk mengirim ulang email verifikasi.
                                            </button>
                                        </p>
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-bold text-sm text-success-600">
                                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 pt-4 border-t border-neutral-100">
                                <x-atoms.button type="primary">{{ __('Simpan Perubahan') }}</x-atoms.button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                       class="text-sm font-bold text-success-600 bg-success-50 px-3 py-1 rounded-full">
                                        Tersimpan.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Keamanan Sandi --}}
                    <div id="password" class="bg-white rounded-[32px] p-8 sm:p-10 shadow-sm border border-neutral-100 scroll-mt-8">
                        <header class="mb-6">
                            <h2 class="text-xl font-extrabold text-neutral-800 uppercase tracking-tight">Keamanan Sandi</h2>
                            <p class="mt-1 text-sm text-neutral-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div class="space-y-1.5">
                                <x-atoms.input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
                                <x-atoms.input id="update_password_current_password" name="current_password" type="password"
                                               class="w-full rounded-2xl"
                                               :error="$errors->updatePassword->has('current_password')"
                                               :messages="$errors->updatePassword->get('current_password')"
                                               autocomplete="current-password" />
                            </div>

                            <div class="space-y-1.5">
                                <x-atoms.input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
                                <x-atoms.input id="update_password_password" name="password" type="password"
                                               class="w-full rounded-2xl"
                                               :error="$errors->updatePassword->has('password')"
                                               :messages="$errors->updatePassword->get('password')"
                                               autocomplete="new-password" />
                            </div>

                            <div class="space-y-1.5">
                                <x-atoms.input-label for="update_password_password_confirmation" :value="__('Konfirmasi Sandi Baru')" />
                                <x-atoms.input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                               class="w-full rounded-2xl"
                                               :error="$errors->updatePassword->has('password_confirmation')"
                                               :messages="$errors->updatePassword->get('password_confirmation')"
                                               autocomplete="new-password" />
                            </div>

                            <div class="flex items-center gap-4 pt-4 border-t border-neutral-100">
                                <x-atoms.button type="primary">{{ __('Perbarui Sandi') }}</x-atoms.button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                       class="text-sm font-bold text-success-600 bg-success-50 px-3 py-1 rounded-full">
                                        Berhasil Diperbarui.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
