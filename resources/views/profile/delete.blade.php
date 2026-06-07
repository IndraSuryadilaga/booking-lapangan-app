<x-app-layout>
    <div class="py-12 bg-neutral-50 min-h-screen pt-28">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex items-center gap-4">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white border border-neutral-200 text-neutral-500 hover:text-neutral-800 hover:border-neutral-300 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-extrabold text-danger-600 tracking-tight">Hapus <span class="text-neutral-800">Akun</span></h2>
                    <p class="text-neutral-500 mt-1">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="px-4 sm:px-0 space-y-6">

                {{-- Warning Card --}}
                <div class="bg-danger-50 rounded-[32px] p-8 border border-danger-200">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-danger-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-danger-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-danger-800 uppercase tracking-tight">Perhatian!</h3>
                            <p class="mt-1 text-sm text-danger-700 leading-relaxed">
                                Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara <strong>permanen</strong>.
                                Tindakan ini tidak dapat dibatalkan. Sebelum menghapus, pastikan Anda sudah mengunduh data yang ingin disimpan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Data yang akan dihapus --}}
                <div class="bg-white rounded-[32px] p-8 shadow-sm border border-neutral-100">
                    <h3 class="text-sm font-extrabold text-neutral-700 uppercase tracking-widest mb-4">Data yang akan dihapus:</h3>
                    <ul class="space-y-3">
                        @foreach([
                            'Informasi profil dan akun Anda',
                            'Riwayat pemesanan lapangan',
                            'Ulasan yang pernah Anda berikan',
                            'Semua data terkait akun ini',
                        ] as $item)
                            <li class="flex items-center gap-3 text-sm text-neutral-600">
                            <span class="w-5 h-5 rounded-full bg-danger-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-danger-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Form Hapus --}}
                <div class="bg-white rounded-[32px] p-8 sm:p-10 shadow-sm border border-neutral-100">
                    <header class="mb-6">
                        <h2 class="text-xl font-extrabold text-neutral-800 uppercase tracking-tight">Konfirmasi Penghapusan</h2>
                        <p class="mt-1 text-sm text-neutral-500">
                            Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini.
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                        @csrf
                        @method('delete')

                        <div class="space-y-1.5">
                            <x-atoms.input-label for="password" :value="__('Kata Sandi')" />
                            <x-atoms.input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full rounded-2xl"
                                placeholder="{{ __('Masukkan kata sandi Anda') }}"
                                :error="$errors->userDeletion->has('password')"
                                :messages="$errors->userDeletion->get('password')" />
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4 border-t border-neutral-100">
                            <a href="{{ route('profile.show') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-neutral-100 text-neutral-700 text-sm font-bold hover:bg-neutral-200 transition-colors">
                                Batal, Kembali
                            </a>
                            <x-atoms.button type="danger" class="w-full sm:w-auto rounded-2xl">
                                {{ __('Ya, Hapus Akun Saya Selamanya') }}
                            </x-atoms.button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
