<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <x-organisms.sidebar />
            </aside>

            <!-- Main Content -->
            <main class="flex-1 space-y-6">
                <!-- Header -->
                <div class="border-b border-neutral-200 pb-5">
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Daftar Booking</h1>
                    <p class="mt-2 text-sm text-neutral-500">Kelola dan pantau transaksi penyewaan lapangan.</p>
                </div>

                <!-- Filters -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Pencarian</label>
                            <x-atoms.input type="text" name="search" placeholder="ID Booking / Nama..." value="{{ request('search') }}" />
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Tanggal Main</label>
                            <x-atoms.input-date name="date" value="{{ request('date') }}" />
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Status</label>
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
                            <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Lapangan</label>
                            <x-atoms.select name="field_id" placeholder="Semua Lapangan" :value="request('field_id')" :options="$fields->map(fn($f) => ['value' => $f->id, 'label' => $f->name])->toArray()" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors">
                                Filter
                            </button>
                            <a href="{{ route('admin.bookings.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">ID Booking</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Pelanggan</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Lapangan / Venue</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Tanggal Booking</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Total Bayar</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase">Status</th>
                                <th class="p-4 text-xs font-semibold text-neutral-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 font-bold text-neutral-900 text-sm">#{{ $booking->id }}</td>
                                    <td class="p-4">
                                        <div class="font-semibold text-neutral-900 text-sm">{{ $booking->user->name ?? 'Guest' }}</div>
                                        <div class="text-xs text-neutral-400">{{ $booking->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-sm font-medium text-neutral-900">{{ $booking->field->name ?? 'Lapangan' }}</div>
                                        <div class="text-xs text-neutral-400 mt-0.5">{{ $booking->field->venue->name ?? 'Venue' }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-neutral-600">
                                        {{ $booking->booking_date->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-sm font-bold text-neutral-900">
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
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold inline-block">
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

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
