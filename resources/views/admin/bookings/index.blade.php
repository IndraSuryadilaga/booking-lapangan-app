<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Daftar Booking</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Kelola dan pantau transaksi penyewaan lapangan.</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm p-6">
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Pencarian</label>
                        <x-atoms.input type="text" name="search" placeholder="ID Booking / Nama..." value="{{ request('search') }}" />
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Tanggal Main</label>
                        <x-atoms.input-date name="date" value="{{ request('date') }}" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Status</label>
                        <x-atoms.select name="status" placeholder="Semua Status" :value="request('status')" :options="[
                            ['value' => 'pending', 'label' => 'Pending'],
                            ['value' => 'paid', 'label' => 'Lunas (Paid)'],
                            ['value' => 'completed', 'label' => 'Selesai'],
                            ['value' => 'cancelled', 'label' => 'Dibatalkan'],
                            ['value' => 'expired', 'label' => 'Kedaluwarsa'],
                        ]" />
                    </div>

                    <!-- Field Dropdown -->
                    <div>
                        <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Lapangan</label>
                        <x-atoms.select name="field_id" placeholder="Semua Lapangan" :value="request('field_id')" :options="$fields->map(fn($f) => ['value' => $f->id, 'label' => $f->name])->toArray()" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-sm">
                            Filter
                        </button>
                        <a href="{{ route('admin.bookings.index') }}" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 font-bold py-2.5 px-4 rounded-xl text-sm transition-colors text-center shadow-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white border border-neutral-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">ID Booking</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Lapangan / Venue</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Tanggal Booking</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Total Bayar</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-xs font-bold text-neutral-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 font-bold text-neutral-900 text-sm">#{{ $booking->id }}</td>
                                    <td class="p-4">
                                        <div class="font-semibold text-neutral-900 text-sm">{{ $booking->user->name ?? 'Guest' }}</div>
                                        <div class="text-xs text-neutral-400 mt-0.5">{{ $booking->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-sm font-semibold text-neutral-900">{{ $booking->field->name ?? 'Lapangan' }}</div>
                                        <div class="text-xs text-neutral-400 mt-0.5 leading-relaxed">{{ $booking->field->venue->name ?? 'Venue' }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-neutral-600 font-medium">
                                        {{ $booking->booking_date->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-sm font-extrabold text-neutral-900">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        @if($booking->status === 'paid')
                                            <x-atoms.badge variant="success">Lunas (Paid)</x-atoms.badge>
                                        @elseif($booking->status === 'pending')
                                            <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                                        @elseif($booking->status === 'completed')
                                            <x-atoms.badge variant="success">Selesai</x-atoms.badge>
                                        @elseif($booking->status === 'cancelled')
                                            <x-atoms.badge variant="danger">Batal</x-atoms.badge>
                                        @else
                                            <x-atoms.badge variant="danger">Expired</x-atoms.badge>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-sm text-neutral-400 italic">Tidak ada data booking yang sesuai filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
