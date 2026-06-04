<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <x-organisms.sidebar />
            </aside>

            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <div class="border-b border-neutral-200 pb-5">
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Tambah Hari Libur</h1>
                    <p class="mt-2 text-sm text-neutral-500">Tambahkan hari libur nasional baru ke sistem.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-xl">
                    <form method="POST" action="{{ route('holidays.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Hari Libur</label>
                            <x-atoms.input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama hari libur (contoh: Tahun Baru Imlek)"
                                required
                            />
                        </div>

                        <div>
                            <label for="holiday_date" class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Hari Libur</label>
                            <x-atoms.input-date
                                name="holiday_date"
                                id="holiday_date"
                                value="{{ old('holiday_date') }}"
                                :error="$errors->has('holiday_date')"
                                :errorMessage="$errors->first('holiday_date')"
                                required
                            />
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                                Simpan Hari Libur
                            </x-atoms.button>
                            <a href="{{ route('holidays.index') }}">
                                <x-atoms.button type="secondary" class="px-5 py-2.5 text-sm" type-button="button">
                                    Batal
                                </x-atoms.button>
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
