<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <div class="border-b border-neutral-200 pb-5">
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Edit Venue: {{ $venue->name }}</h1>
                    <p class="mt-2 text-sm text-neutral-500">Perbarui informasi dasar, kebijakan, logo, kategori, dan fasilitas venue.</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <strong class="text-sm">Oops! Terjadi kesalahan:</strong>
                        <ul class="list-disc pl-5 mt-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <form action="{{ route('admin.venues.update', $venue->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Venue -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Venue</label>
                            <x-atoms.input type="text" name="name" placeholder="Contoh: Gelora Bung Karno Arena" value="{{ old('name', $venue->name) }}" required />
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Alamat Lengkap</label>
                            <x-atoms.input-textarea name="address" placeholder="Tulis alamat jalan lengkap..." rows="3" required>{{ old('address', $venue->address) }}</x-atoms.input-textarea>
                        </div>

                        <!-- Kota & Provinsi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Kota</label>
                                <x-atoms.input type="text" name="city" placeholder="Contoh: Jakarta Pusat" value="{{ old('city', $venue->city) }}" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Provinsi</label>
                                <x-atoms.input type="text" name="province" placeholder="Contoh: DKI Jakarta" value="{{ old('province', $venue->province) }}" required />
                            </div>
                        </div>

                        <!-- Koordinat (Latitude & Longitude) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Latitude</label>
                                <x-atoms.input type="text" name="latitude" placeholder="-6.218388" value="{{ old('latitude', $venue->latitude) }}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Longitude</label>
                                <x-atoms.input type="text" name="longitude" placeholder="106.802198" value="{{ old('longitude', $venue->longitude) }}" />
                            </div>
                        </div>

                        <!-- Kebijakan Refund & Reschedule -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Kebijakan Refund</label>
                                <x-atoms.input-textarea name="refund_policy" placeholder="Contoh: Refund 50% jika dibatalkan H-2..." rows="3">{{ old('refund_policy', $venue->refund_policy) }}</x-atoms.input-textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Kebijakan Reschedule</label>
                                <x-atoms.input-textarea name="reschedule_policy" placeholder="Contoh: Maksimal reschedule 1x..." rows="3">{{ old('reschedule_policy', $venue->reschedule_policy) }}</x-atoms.input-textarea>
                            </div>
                        </div>

                        <!-- Logo Venue -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Logo Venue (Max: 5MB)</label>
                            @if($venue->logo)
                                <div class="mb-3 flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $venue->logo) }}" alt="Logo saat ini" class="w-16 h-16 object-cover rounded-xl border border-slate-200">
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-xs text-neutral-400">Biarkan kosong jika tidak ingin mengubah logo.</span>
                                        <button type="button"
                                                onclick="if(confirm('Apakah Anda yakin ingin menghapus logo ini?')) { document.getElementById('delete-logo-form').submit(); }"
                                                class="text-xs font-semibold text-red-600 hover:text-red-700 w-fit">
                                            Hapus Logo
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <x-atoms.input-file name="logo" accept="image/*" />
                        </div>

                        <!-- Kategori Olahraga (Checkbox List) -->
                        <div class="border-t border-slate-100 pt-6">
                            <label class="block text-sm font-bold text-neutral-800 mb-3">Kategori Olahraga yang Tersedia</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @php
                                    $currentCats = $venue->sportsCategories->pluck('id')->toArray();
                                @endphp
                                @foreach($sportsCategories as $cat)
                                    <label class="inline-flex items-center gap-2 text-sm text-neutral-600 cursor-pointer">
                                        <input type="checkbox" name="sports_category_ids[]" value="{{ $cat->id }}"
                                               {{ in_array($cat->id, old('sports_category_ids', $currentCats)) ? 'checked' : '' }}
                                               class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <span>{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Fasilitas (Checkbox List) -->
                        <div class="border-t border-slate-100 pt-6">
                            <label class="block text-sm font-bold text-neutral-800 mb-3">Fasilitas Penunjang</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @php
                                    $currentFacs = $venue->facilities->pluck('id')->toArray();
                                @endphp
                                @foreach($facilities as $fac)
                                    <label class="inline-flex items-center gap-2 text-sm text-neutral-600 cursor-pointer">
                                        <input type="checkbox" name="facility_ids[]" value="{{ $fac->id }}"
                                               {{ in_array($fac->id, old('facility_ids', $currentFacs)) ? 'checked' : '' }}
                                               class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <span>{{ $fac->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.venues.index') }}">
                                <x-atoms.button type="button" variant="secondary">Batal</x-atoms.button>
                            </a>
                            <x-atoms.button type="primary" class="px-6 py-2.5">
                                Simpan Perubahan
                            </x-atoms.button>
                        </div>
                    </form>

                    @if($venue->logo)
                        <form id="delete-logo-form" action="{{ route('admin.venues.delete-logo', $venue->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
