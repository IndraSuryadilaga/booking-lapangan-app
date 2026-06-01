<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-3">Ringkasan Pemesanan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold">Jumlah pemesanan per status</h4>
                            @if($bookingsByStatus && $bookingsByStatus->isNotEmpty())
                                <ul class="mt-2 space-y-1">
                                    @foreach($bookingsByStatus as $status => $total)
                                        <li class="flex justify-between border-b py-2">
                                            <span class="capitalize">{{ $status }}</span>
                                            <span class="font-semibold">{{ $total }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-600">Tidak ada pemesanan.</p>
                            @endif
                        </div>

                        <div>
                            <h4 class="font-semibold">Pemesanan aktif terbaru</h4>
                            @if($latestActiveBookings && $latestActiveBookings->isNotEmpty())
                                <ul class="mt-2 space-y-2">
                                    @foreach($latestActiveBookings as $b)
                                        <li class="p-3 border rounded">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="text-sm text-gray-700">{{ optional($b->field)->name ?? 'Lapangan' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $b->booking_date->format('Y-m-d') }} • {{ ucfirst($b->status) }}</div>
                                                </div>
                                                <div class="text-sm font-medium text-gray-800">Rp {{ number_format($b->total_price, 0, ',', '.') }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-600">Tidak ada pemesanan aktif.</p>
                            @endif
                        </div>
                    </div>

                    @if(isset($adminBookingsToday))
                        <div class="mt-6 border-t pt-6">
                            <h3 class="text-lg font-medium mb-2">Admin: Pemesanan Hari Ini</h3>
                            <p class="text-2xl font-semibold">{{ $adminBookingsToday }}</p>
                            <p class="text-sm text-gray-600">Jumlah pemesanan yang terdaftar untuk venue yang Anda kelola hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
