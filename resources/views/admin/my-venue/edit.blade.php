<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Profil Venue Saya</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Perbarui profil venue, kebijakan, logo, kategori, dan fasilitas yang tersedia untuk pelanggan Anda.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

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

            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6">
                <form action="{{ route('admin.venues.my-venue.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Venue -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Nama Venue</label>
                        <x-atoms.input type="text" name="name" placeholder="Contoh: Gelora Bung Karno Arena" value="{{ old('name', $venue->name) }}" required />
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Alamat Lengkap</label>
                        <x-atoms.input-textarea name="address" placeholder="Tulis alamat jalan lengkap..." rows="3" required>{{ old('address', $venue->address) }}</x-atoms.input-textarea>
                    </div>

                    <!-- Kota & Provinsi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Kota</label>
                            <x-atoms.input type="text" name="city" placeholder="Contoh: Jakarta Pusat" value="{{ old('city', $venue->city) }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Provinsi</label>
                            <x-atoms.input type="text" name="province" placeholder="Contoh: DKI Jakarta" value="{{ old('province', $venue->province) }}" required />
                        </div>
                    </div>

                    <!-- Koordinat (Latitude & Longitude) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Latitude</label>
                            <x-atoms.input type="text" name="latitude" placeholder="-6.218388" value="{{ old('latitude', $venue->latitude) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Longitude</label>
                            <x-atoms.input type="text" name="longitude" placeholder="106.802198" value="{{ old('longitude', $venue->longitude) }}" />
                        </div>
                    </div>

                    <!-- Kebijakan Refund & Reschedule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Kebijakan Refund</label>
                            <x-atoms.input-textarea name="refund_policy" placeholder="Contoh: Refund 50% jika dibatalkan H-2..." rows="3">{{ old('refund_policy', $venue->refund_policy) }}</x-atoms.input-textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 mb-2">Kebijakan Reschedule</label>
                            <x-atoms.input-textarea name="reschedule_policy" placeholder="Contoh: Maksimal reschedule 1x..." rows="3">{{ old('reschedule_policy', $venue->reschedule_policy) }}</x-atoms.input-textarea>
                        </div>
                    </div>

                    <!-- Logo Venue -->
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 mb-2">Logo Venue (Max: 5MB)</label>
                        @if($venue->logo)
                            <div class="mb-4 flex items-center gap-4 p-3 bg-neutral-50 rounded-xl border border-neutral-100 w-fit">
                                <img src="{{ $venue->logo_url }}" alt="Logo saat ini" class="w-16 h-16 object-cover rounded-xl border border-neutral-200 shadow-sm">
                                <div class="flex flex-col gap-1.5">
                                    <span class="text-xs text-neutral-400 font-medium">Biarkan kosong jika tidak ingin mengubah logo.</span>
                                    <button type="button"
                                            onclick="if(confirm('Apakah Anda yakin ingin menghapus logo ini?')) { document.getElementById('delete-logo-form').submit(); }"
                                            class="text-xs font-bold text-danger-600 hover:text-danger-700 transition-colors w-fit">
                                        Hapus Logo
                                    </button>
                                </div>
                            </div>
                        @endif
                        <x-atoms.input-file name="logo" accept="image/*" />
                    </div>

                    <!-- Kategori Olahraga (Checkbox List) -->
                    <div class="border-t border-neutral-100 pt-6">
                        <label class="block text-sm font-bold text-neutral-800 mb-3">Kategori Olahraga yang Tersedia</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @php
                                $currentCats = $venue->sportsCategories->pluck('id')->toArray();
                                $sportsCategories = \App\Models\SportsCategory::all();
                            @endphp
                            @foreach($sportsCategories as $cat)
                                <label class="inline-flex items-center gap-3 text-sm text-neutral-600 cursor-pointer bg-neutral-50/50 hover:bg-neutral-50 border border-neutral-200/50 p-3 rounded-xl transition-colors select-none">
                                    <input type="checkbox" name="sports_category_ids[]" value="{{ $cat->id }}"
                                           {{ in_array($cat->id, old('sports_category_ids', $currentCats)) ? 'checked' : '' }}
                                           class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                                    <span class="font-semibold text-neutral-700">{{ $cat->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Fasilitas (Checkbox List) -->
                    <div class="border-t border-neutral-100 pt-6">
                        <label class="block text-sm font-bold text-neutral-800 mb-3">Fasilitas Penunjang</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @php
                                $currentFacs = $venue->facilities->pluck('id')->toArray();
                                $facilities = \App\Models\Facility::all();
                            @endphp
                            @foreach($facilities as $fac)
                                <label class="inline-flex items-center gap-3 text-sm text-neutral-600 cursor-pointer bg-neutral-50/50 hover:bg-neutral-50 border border-neutral-200/50 p-3 rounded-xl transition-colors select-none">
                                    <input type="checkbox" name="facility_ids[]" value="{{ $fac->id }}"
                                           {{ in_array($fac->id, old('facility_ids', $currentFacs)) ? 'checked' : '' }}
                                           class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                                    <span class="font-semibold text-neutral-700">{{ $fac->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-neutral-100">
                        <x-atoms.button type="primary" class="px-6 py-2.5 text-sm">
                            Simpan Perubahan
                        </x-atoms.button>
                    </div>
                </form>

                @if($venue->logo)
                    <form id="delete-logo-form" action="{{ route('admin.venues.my-venue.delete-logo') }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
