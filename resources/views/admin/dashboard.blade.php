<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-200 pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Admin Dashboard</h1>
                    <p class="mt-2 text-sm text-neutral-500 font-normal">Pantau operasional, okupansi lapangan, dan pendapatan secara real-time.</p>
                </div>
            </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-neutral-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 flex items-center gap-4">
                <div class="p-3 bg-primary-50 rounded-xl text-primary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Booking Hari Ini</p>
                    <h3 class="text-3xl font-extrabold text-neutral-900 mt-1 tracking-tight">{{ $totalBookingsToday ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white border border-neutral-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 flex items-center gap-4">
                <div class="p-3 bg-warning-50 rounded-xl text-warning-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Menunggu Bayar</p>
                    <h3 class="text-3xl font-extrabold text-neutral-900 mt-1 tracking-tight">{{ $pendingPayments ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white border border-neutral-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 flex items-center gap-4">
                <div class="p-3 bg-green-50 rounded-xl text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Occupancy (Live)</p>
                    <h3 class="text-3xl font-extrabold text-neutral-900 mt-1 tracking-tight">{{ $liveOccupancy ?? 0 }} <span class="text-sm font-semibold text-neutral-500">Lap.</span></h3>
                </div>
            </div>

            <div class="bg-white border border-neutral-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 flex items-center gap-4">
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                    <h3 class="text-2xl font-extrabold text-neutral-900 mt-1 tracking-tight">Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-neutral-800 tracking-tight">Jadwal Hari Ini (Paid Only)</h2>
                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="p-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="p-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Lapangan / Venue</th>
                                <th class="p-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Waktu</th>
                                <th class="p-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        @forelse($todayBookings ?? [] as $booking)
                            @php
                                $firstSlot = $booking->slots->sortBy('start_time')->first();
                                $lastSlot = $booking->slots->sortBy('start_time')->last();
                                $timeStr = $firstSlot ? substr($firstSlot->start_time, 0, 5) . ' - ' . substr($lastSlot->end_time, 0, 5) : '-';
                            @endphp
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors">
                                <td class="p-3 text-sm font-medium text-neutral-900">{{ $booking->user->name ?? 'Guest' }}</td>
                                <td class="p-3 text-sm text-neutral-600">
                                    <div>{{ $booking->field->name ?? 'Lapangan' }}</div>
                                    <div class="text-xs text-neutral-400">{{ $booking->field->venue->name ?? 'Venue' }}</div>
                                </td>
                                <td class="p-3 text-sm text-neutral-600">{{ $timeStr }}</td>
                                <td class="p-3 text-sm">
                                    <x-atoms.badge variant="success">Lunas</x-atoms.badge>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-sm text-neutral-400 italic">Tidak ada jadwal booking lunas untuk hari ini.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-neutral-800">Tren Pendapatan & Booking (7 Hari Terakhir)</h2>
                <div class="relative h-64 w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('trendChart');
                if(!ctx) return;

                const labels = @json($chartLabels ?? []);
                const bookingsData = @json($chartBookings ?? []);
                const revenueData = @json($chartRevenue ?? []);

                new Chart(ctx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Jumlah Booking (Kiri)',
                                data: bookingsData,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Pendapatan (Kanan, Rp)',
                                data: revenueData,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            });
        </script>
    @endpush
</x-app-layout>
