<x-app-layout>
    <div class="container mx-auto px-4 py-8" x-data="{
        ...slotCalendar({{ $field->id }}),
        mainImage: '{{ $field->images->isNotEmpty() ? asset('storage/' . ($field->images->firstWhere('is_primary', true)?->image_path ?? $field->images->first()->image_path)) : '' }}'
    }">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-24"> {{-- Padding bottom untuk memberi ruang bagi tombol sticky --}}

            {{-- Galeri Foto --}}
            <div class="md:col-span-2">
                <div class="mb-4">
                    @if($field->images->isNotEmpty())
                        <img :src="mainImage" alt="{{ $field->name }}" class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center"><p class="text-gray-500">Tidak ada foto</p></div>
                    @endif
                </div>
                {{-- Thumbnails --}}
                <div class="flex flex-wrap gap-2">
                    @foreach($field->images as $image)
                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            @click="mainImage = '{{ asset('storage/' . $image->image_path) }}'"
                            alt="Thumbnail"
                            class="w-24 h-24 object-cover rounded-md cursor-pointer border-2 hover:border-primary-500 transition-colors"
                            :class="mainImage === '{{ asset('storage/' . $image->image_path) }}' ? 'border-primary-500' : 'border-transparent'"
                        >
                    @endforeach
                </div>
            </div>

            {{-- Info & Booking --}}
            <div>
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $field->name }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ $field->venue->name }}</p>
                    <div class="space-y-2 text-gray-700">
                        <p><span class="font-semibold text-gray-800">Kategori:</span> {{ $field->sportsCategory->name }}</p>
                        <p><span class="font-semibold text-gray-800">Material:</span> {{ $field->surface_material ?? 'N/A' }}</p>
                        @if($field->operatingHours->isNotEmpty())
                            <p><span class="font-semibold text-gray-800">Jam Buka:</span> {{ Carbon\Carbon::parse($field->operatingHours->first()->open_time)->format('H:i') }} - {{ Carbon\Carbon::parse($field->operatingHours->first()->close_time)->format('H:i') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Komponen Kalender Alpine.js --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Pilih Jadwal</h2>
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" id="date" x-model="selectedDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+60 days')) }}" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <template x-if="isLoading"><div class="flex justify-center items-center h-48"><div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary-500"></div></div></template>
                    <template x-if="!isLoading && slots.length > 0"><div class="grid grid-cols-3 sm:grid-cols-4 gap-2 text-center"><template x-for="slot in slots" :key="slot.start"><div @click="toggleSlot(slot)" :class="getSlotClass(slot)" class="p-2 border rounded-md transition-colors duration-150 flex flex-col justify-center min-h-[60px]"><p class="font-semibold" x-text="slot.start"></p><p class="text-[10px] opacity-75" x-text="formatPrice(slot.price)"></p></div></template></div></template>
                    <template x-if="!isLoading && slots.length === 0"><div class="text-center bg-gray-50 p-4 rounded-md"><p class="text-gray-500">Tidak ada slot tersedia atau lapangan tutup.</p></div></template>
                    <div class="mt-6 flex flex-wrap gap-x-4 gap-y-2 text-sm text-gray-600">
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-green-100 border border-green-300 mr-2"></span>Tersedia</div>
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-primary-600 mr-2"></span>Dipilih</div>
                        <div class="flex items-center"><span class="w-4 h-4 rounded-full bg-red-100 border border-red-200 mr-2"></span>Dipesan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Konfirmasi --}}
        <div x-show="selectedSlots.length > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-4" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg-top" style="display: none;">
            <div class="container mx-auto flex justify-between items-center">
                <div>
                    <p class="font-semibold text-lg">Total Harga</p>
                    <p class="text-2xl font-bold text-primary-600" x-text="formatPrice(totalPrice)"></p>
                </div>
                @auth
                    <form action="{{ route('bookings.confirm') }}" method="GET">
                        <input type="hidden" name="field_id" :value="fieldId">
                        <input type="hidden" name="date" :value="selectedDate">
                        <template x-for="(slot, index) in selectedSlots" :key="index">
                            <input type="hidden" :name="'slots[' + index + '][start]'" :value="slot.start">
                            <input type="hidden" :name="'slots[' + index + '][end]'" :value="slot.end">
                            <input type="hidden" :name="'slots[' + index + '][price]'" :value="slot.price">
                        </template>
                        <button type="submit" class="btn btn-primary btn-lg">
                            Lanjut Konfirmasi (<span x-text="selectedSlots.length"></span> Slot)
                        </button>
                    </form>
                @else
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary btn-lg">
                        Login untuk Memesan
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
