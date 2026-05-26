<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Lapangan: {{ $field->name }}</h2>
                        <p class="text-gray-600">Atur jam operasional dan skema harga untuk lapangan ini.</p>
                    </div>

                    <form action="{{ route('fields.settings.update', $field->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">1. Jam Operasional (7 Hari)</h3>
                            
                            @php
                                $days = [
                                    0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 
                                    3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
                                ];
                            @endphp

                            <div class="space-y-4">
                                @foreach($days as $index => $dayName)
                                    <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-neutral-800/50 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                        
                                        <div class="w-1/4">
                                            <x-atoms.select-checkbox 
                                                name="operating_hours[{{ $index }}][is_open]" 
                                                value="1" 
                                                :checked="true" 
                                                label="{{ $dayName }}" 
                                            />
                                        </div>

                                        <div class="w-1/3">
                                            <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-1">Jam Buka</label>
                                            <x-atoms.input-time 
                                                name="operating_hours[{{ $index }}][open_time]" 
                                                value="08:00" 
                                            />
                                        </div>

                                        <div class="w-1/3">
                                            <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-1">Jam Tutup</label>
                                            <x-atoms.input-time 
                                                name="operating_hours[{{ $index }}][close_time]" 
                                                value="22:00" 
                                            />
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">2. Skema Harga</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Weekday (Senin-Jumat)</label>
                                    <x-atoms.input-number 
                                        name="pricings[weekday]" 
                                        placeholder="100000" 
                                        prefix="Rp" 
                                        :isCurrency="true" 
                                        :min="0" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Weekend (Sabtu-Minggu)</label>
                                    <x-atoms.input-number 
                                        name="pricings[weekend]" 
                                        placeholder="150000" 
                                        prefix="Rp" 
                                        :isCurrency="true" 
                                        :min="0" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari Libur Nasional</label>
                                    <x-atoms.input-number 
                                        name="pricings[holiday]" 
                                        placeholder="200000" 
                                        prefix="Rp" 
                                        :isCurrency="true" 
                                        :min="0" 
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t gap-4    ">
                            <x-atoms.button type="secondary" href="{{ route('fields.index') }}">
                                Batal
                            </x-atoms.button>
                            <x-atoms.button type="primary" >
                                Simpan Pengaturan
                            </x-atoms.button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>