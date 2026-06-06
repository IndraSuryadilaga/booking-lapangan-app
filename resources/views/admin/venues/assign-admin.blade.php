<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Tugaskan Admin</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Pilih salah satu akun admin untuk mengelola venue <strong>{{ $venue->name }}</strong>.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('admin.venues.index') }}">
                        <x-atoms.button type="secondary" class="px-4 py-2 text-sm">
                            Kembali
                        </x-atoms.button>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6">
                <form action="{{ route('admin.venues.store-assign-admin', $venue->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Select Admin -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Pilih Akun Admin</label>
                        @php
                            $options = $admins->map(fn($admin) => ['value' => $admin->id, 'label' => $admin->name . ' (' . $admin->email . ')'])->toArray();
                            array_unshift($options, ['value' => '', 'label' => '-- Lepas Penugasan Admin (Kosongkan) --']);
                        @endphp
                        <x-atoms.select name="admin_id" placeholder="Pilih akun admin..." :options="$options" :value="$venue->admin_id" />
                        <p class="text-xs text-neutral-400 mt-2 font-medium">Hanya menampilkan admin yang belum memegang venue lain.</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-neutral-100">
                        <a href="{{ route('admin.venues.index') }}">
                            <x-atoms.button type="button" variant="secondary" class="px-5 py-2.5 text-sm">Batal</x-atoms.button>
                        </a>
                        <x-atoms.button type="primary" class="px-6 py-2.5 text-sm">
                            Tugaskan Admin
                        </x-atoms.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
