<x-app-layout>
    <div class="py-12 bg-neutral-50 min-h-screen pt-28">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-neutral-800 tracking-tight">Profil <span class="text-primary-500">Saya</span></h2>
                <p class="text-neutral-500 mt-2">Informasi akun dan data pribadi Anda.</p>
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

                        <div class="mt-6 pt-6 border-t border-neutral-100 flex flex-col gap-3">
                            <x-atoms.button
                                href="{{ route('profile.edit') }}"
                                type="primary"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                </x-slot>
                                Edit Profil
                            </x-atoms.button>
                            <x-atoms.button
                                href="{{ route('profile.delete') }}"
                                type="danger"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </x-slot>
                                Hapus Akun
                            </x-atoms.button>
                        </div>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:col-span-8 space-y-8 px-4 sm:px-0">

                    {{-- Info Pribadi (read-only) --}}
                    <div class="bg-white rounded-[32px] p-8 sm:p-10 shadow-sm border border-neutral-100">
                        <header class="mb-6 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-extrabold text-neutral-800 uppercase tracking-tight">Informasi Pribadi</h2>
                                <p class="mt-1 text-sm text-neutral-500">Detail akun Anda saat ini.</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-primary-500 hover:text-primary-600 transition-colors">
                                Edit →
                            </a>
                        </header>

                        <dl class="space-y-5">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 py-4 border-b border-neutral-100">
                                <dt class="text-xs font-bold uppercase tracking-widest text-neutral-400 sm:w-40 shrink-0">Nama Lengkap</dt>
                                <dd class="text-base font-semibold text-neutral-800">{{ $user->name }}</dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 py-4 border-b border-neutral-100">
                                <dt class="text-xs font-bold uppercase tracking-widest text-neutral-400 sm:w-40 shrink-0">Alamat Email</dt>
                                <dd class="flex items-center gap-2">
                                    <span class="text-base font-semibold text-neutral-800">{{ $user->email }}</span>
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-success-50 text-success-600 border border-success-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Terverifikasi
                                        </span>
                                    @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-warning-50 text-warning-600 border border-warning-200">
                                            Belum Diverifikasi
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 py-4">
                                <dt class="text-xs font-bold uppercase tracking-widest text-neutral-400 sm:w-40 shrink-0">Bergabung Sejak</dt>
                                <dd class="text-base font-semibold text-neutral-800">{{ $user->created_at->translatedFormat('d F Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Keamanan --}}
                    <div class="bg-white rounded-[32px] p-8 sm:p-10 shadow-sm border border-neutral-100">
                        <header class="mb-6 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-extrabold text-neutral-800 uppercase tracking-tight">Keamanan Akun</h2>
                                <p class="mt-1 text-sm text-neutral-500">Informasi keamanan akun Anda.</p>
                            </div>
                            <a href="{{ route('profile.edit') }}#password" class="text-sm font-bold text-primary-500 hover:text-primary-600 transition-colors">
                                Ubah Sandi →
                            </a>
                        </header>

                        <dl class="space-y-5">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 py-4 border-b border-neutral-100">
                                <dt class="text-xs font-bold uppercase tracking-widest text-neutral-400 sm:w-40 shrink-0">Kata Sandi</dt>
                                <dd class="flex items-center gap-2">
                                    <span class="text-base font-semibold text-neutral-800 tracking-widest">••••••••</span>
                                </dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 py-4">
                                <dt class="text-xs font-bold uppercase tracking-widest text-neutral-400 sm:w-40 shrink-0">Terakhir Diperbarui</dt>
                                <dd class="text-base font-semibold text-neutral-800">
                                    {{ $user->updated_at->translatedFormat('d F Y') }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
