<x-app-layout>
    <div class="py-12 bg-neutral-50 dark:bg-neutral-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('fields.settings.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 flex flex-col h-full">
                        
                        <div class="bg-white dark:bg-neutral-800 p-6 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 mb-6">
                            <h3 class="text-lg font-bold mb-6 text-neutral-800 dark:text-white">Informasi Utama</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nama Lapangan</label>
                                    <input type="text" name="name" value="{{ old('name', $field->name) }}" class="w-full rounded-full border-neutral-300 dark:bg-neutral-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipe Lapangan</label>
                                    <select name="type" class="w-full rounded-full border-neutral-300 dark:bg-neutral-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                                        <option value="Indoor" {{ $field->type == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                        <option value="Outdoor" {{ $field->type == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                                        <option value="Semi-Indoor" {{ $field->type == 'Semi-Indoor' ? 'selected' : '' }}>Semi-Indoor</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Material Permukaan</label>
                                    <input type="text" name="surface_material" value="{{ old('surface_material', $field->surface_material) }}" placeholder="Contoh: Vinyl, Rumput Sintetis" class="w-full rounded-full border-neutral-300 dark:bg-neutral-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                                </div>

                                <div class="pt-2">
                                    <x-atoms.select-toggle name="is_active" value="1" :checked="$field->is_active" label="Status Lapangan Aktif" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Deskripsi</label>
                                    <textarea name="description" rows="4" class="w-full rounded-xl border-neutral-300 dark:bg-neutral-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">{{ old('description', $field->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-neutral-800 p-6 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 mt-auto">
                            <h3 class="text-lg font-bold mb-4 text-neutral-800 dark:text-white">Galeri Foto</h3>
                            
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                @foreach($field->images as $image)
                                    <div class="relative group aspect-square">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover rounded-lg border {{ $image->is_primary ? 'border-primary-500 ring-2 ring-primary-500' : 'border-neutral-200' }}">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center space-x-1">
                                            <a href="{{ route('fields.images.delete', $image->id) }}" class="p-1 bg-white rounded-full text-red-500 hover:bg-red-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Tambah Foto Baru</label>
                            <input type="file" name="images[]" multiple class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        </div>
                        
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white dark:bg-neutral-800 p-8 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-bold mb-6 text-neutral-800 dark:text-white">Jam Operasional (7 Hari)</h3>
                            
                            @php
                                $days = [0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($days as $index => $dayName)
                                    @php
                                        $hourData = $field->operatingHours->where('day_of_week', $index)->first();
                                    @endphp
                                    
                                    <div class="p-5 bg-white dark:bg-neutral-900/50 rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-between shadow-sm">
                                        
                                        <div class="flex-shrink-0">
                                            <x-atoms.select-checkbox 
                                                name="operating_hours[{{ $index }}][is_open]" 
                                                value="1" 
                                                :checked="$hourData ? $hourData->is_open : true" 
                                                label="{{ $dayName }}" 
                                            />
                                        </div>

                                        <div class="flex flex-col space-y-3">
                                            
                                            <div class="flex items-center justify-start space-x-3">
                                                <span class="text-xs text-neutral-500 font-medium w-16 text-right mr-1">jam buka</span>
                                                <div class="w-36">
                                                    <x-atoms.input-time name="operating_hours[{{ $index }}][open_time]" :value="$hourData ? substr($hourData->open_time, 0, 5) : '08:00'" />
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-start space-x-3">
                                                <span class="text-xs text-neutral-500 font-medium w-16 text-right mr-1">jam tutup</span>
                                                <div class="w-36">
                                                    <x-atoms.input-time name="operating_hours[{{ $index }}][close_time]" :value="$hourData ? substr($hourData->close_time, 0, 5) : '22:00'" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white dark:bg-neutral-800 p-8 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-bold mb-6 text-neutral-800 dark:text-white">Skema Harga</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach(['weekday' => 'Senin - Jumat', 'weekend' => 'Sabtu - Minggu', 'holiday' => 'Libur Nasional'] as $type => $label)
                                    @php
                                        $pricingData = $field->pricing->where('day_type', $type)->first();
                                    @endphp
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ $label }}</label>
                                        <x-atoms.input-number 
                                            name="pricings[{{ $type }}]" 
                                            value="{{ $pricingData ? $pricingData->price_per_slot : '' }}"
                                            placeholder="100000" 
                                            prefix="Rp" 
                                            :isCurrency="true" 
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div> 

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('fields.index') }}" class="px-8 py-2.5 bg-neutral-200 text-neutral-700 rounded-full hover:bg-neutral-300 transition-colors font-bold text-sm flex items-center">Batal</a>
                    <button type="submit" class="px-8 py-2.5 bg-primary-500 text-white rounded-full hover:bg-primary-600 shadow-lg shadow-primary-500/30 transition-all font-bold text-sm">
                        Simpan Semua Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>