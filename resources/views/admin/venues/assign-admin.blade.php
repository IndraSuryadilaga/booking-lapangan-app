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
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Tugaskan Admin: {{ $venue->name }}</h1>
                    <p class="mt-2 text-sm text-neutral-500">Pilih salah satu akun admin yang belum terdaftar di venue mana pun untuk mengelola venue ini.</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-2xl">
                    <form action="{{ route('admin.venues.store-assign-admin', $venue->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Select Admin -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Pilih Akun Admin</label>
                            @php
                                $options = $admins->map(fn($admin) => ['value' => $admin->id, 'label' => $admin->name . ' (' . $admin->email . ')'])->toArray();
                                array_unshift($options, ['value' => '', 'label' => '-- Lepas Penugasan Admin (Kosongkan) --']);
                            @endphp
                            <x-atoms.select name="admin_id" placeholder="Pilih akun admin..." :options="$options" :value="$venue->admin_id" />
                            <p class="text-xs text-neutral-400 mt-2">Hanya menampilkan admin yang belum memegang venue lain.</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.venues.index') }}">
                                <x-atoms.button type="secondary">Kembali</x-atoms.button>
                            </a>
                            <x-atoms.button type="primary" class="px-6 py-2.5">
                                Tugaskan Admin
                            </x-atoms.button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
