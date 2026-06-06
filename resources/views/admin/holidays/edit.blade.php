<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <div class="border-b border-neutral-200 pb-5">
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Edit Hari Libur</h1>
                    <p class="mt-2 text-sm text-neutral-500">Ubah nama atau tanggal hari libur nasional.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-xl">
                    <form action="{{ route('holidays.update', $holiday->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Hari Libur</label>
                            <x-atoms.input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $holiday->name) }}"
                                placeholder="Masukkan nama hari libur"
                                required
                            />
                        </div>

                        <div>
                            <label for="holiday_date" class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Hari Libur</label>
                            <x-atoms.input-date
                                name="holiday_date"
                                id="holiday_date"
                                value="{{ old('holiday_date', $holiday->holiday_date ? \Carbon\Carbon::parse($holiday->holiday_date)->format('Y-m-d') : '') }}"
                                :error="$errors->has('holiday_date')"
                                :errorMessage="$errors->first('holiday_date')"
                                required
                            />
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                                Perbarui Hari Libur
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
