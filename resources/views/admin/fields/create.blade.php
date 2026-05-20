<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Lapangan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-gray-700">Nama Lapangan <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                <option value="">Pilih Kategori</option>
                                <option value="Futsal">Futsal</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Basket">Basket</option>
                                <option value="Voli">Voli</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-gray-700">Harga Per Slot (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price_per_slot" min="0" step="10000" required class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-gray-700">Foto Lapangan</label>
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mt-8">Jam Operasional</h3>
                    
                    <div class="space-y-4">
                        @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                        @foreach($days as $day)
                        <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="w-24 font-medium text-gray-700">{{ $day }}</div>
                            
                            <div class="flex items-center gap-2">
                                <input type="time" name="operating_hours[{{ $day }}][open_time]" class="rounded-md border-gray-300 text-sm">
                                <span>-</span>
                                <input type="time" name="operating_hours[{{ $day }}][close_time]" class="rounded-md border-gray-300 text-sm">
                            </div>

                            <label class="flex items-center gap-2 ml-auto cursor-pointer">
                                <input type="checkbox" name="operating_hours[{{ $day }}][is_closed]" value="1" class="rounded text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-600">Tutup / Libur</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="pt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150">
                            Daftarkan Lapangan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>