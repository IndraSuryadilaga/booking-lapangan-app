<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Edit Fasilitas</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Ubah nama fasilitas venue.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('facilities.index') }}">
                        <x-atoms.button type="secondary" class="px-4 py-2 text-sm">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            <!-- Error Alerts -->
            @if($errors->any())
                <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl">
                    <strong class="text-sm font-semibold">Oops! Terjadi kesalahan:</strong>
                    <ul class="list-disc pl-5 mt-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6">
                <form action="{{ route('facilities.update', $facility->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-bold text-neutral-700 mb-2">Nama Fasilitas</label>
                        <x-atoms.input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $facility->name) }}"
                            placeholder="Masukkan nama fasilitas"
                            required
                        />
                    </div>

                    <div class="flex items-center gap-3 pt-6 border-t border-neutral-100">
                        <x-atoms.button type="primary" class="px-5 py-2.5 text-sm font-semibold shadow-sm hover:shadow transition-all">
                            Perbarui Fasilitas
                        </x-atoms.button>
                        <a href="{{ route('facilities.index') }}">
                            <x-atoms.button type="secondary" class="px-5 py-2.5 text-sm font-medium transition-all" type-button="button">
                                Batal
                            </x-atoms.button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
