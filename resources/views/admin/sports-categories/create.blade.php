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
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Tambah Kategori Olahraga</h1>
                    <p class="mt-2 text-sm text-neutral-500">Buat kategori olahraga baru untuk mengelompokkan lapangan dan venue.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-xl">
                    <form method="POST" action="{{ route('sports-categories.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Kategori</label>
                            <x-atoms.input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama kategori (contoh: Badminton)"
                                required
                            />
                        </div>

                        <div>
                            <span class="block text-sm font-medium text-neutral-700 mb-2">Status Kategori</span>
                            <x-atoms.select-toggle
                                name="is_active"
                                id="is_active"
                                :checked="true"
                                label="Kategori Aktif (Dapat digunakan oleh lapangan/venue)"
                            />
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <x-atoms.button type="primary" class="px-5 py-2.5 text-sm">
                                Simpan Kategori
                            </x-atoms.button>
                            <a href="{{ route('sports-categories.index') }}">
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