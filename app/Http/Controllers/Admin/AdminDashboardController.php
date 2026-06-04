<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $todayStr = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        // Verify that only admin or super-admin can access
        if (!$user || !in_array($user->role, ['admin', 'super-admin'])) {
            abort(403);
        }

        // 1. Total Booking Hari Ini (status = paid, booking_date = today)
        $totalBookingsToday = Booking::where('status', 'paid')
            ->whereDate('booking_date', $todayStr)
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->count();

        // 2. Menunggu Pembayaran (status = pending)
        $pendingPayments = Booking::where('status', 'pending')
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->count();

        // 3. Lapangan Sedang Dipakai (Live Occupancy)
        $liveOccupancy = BookingSlot::where('booking_date', $todayStr)
            ->where('start_time', '<=', $nowTime)
            ->where('end_time', '>', $nowTime)
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('status', 'paid');
                if ($user->isAdmin()) {
                    $q->whereHas('field.venue', function ($qv) use ($user) {
                        $qv->where('admin_id', $user->id);
                    });
                }
            })
            ->distinct('field_id')
            ->count('field_id');

        // 4. Pendapatan Bulan Ini (status = paid, booking_date in current month)
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        $monthlyRevenue = Booking::where('status', 'paid')
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->sum('total_price');

        // 5. Today's Schedule Table (status = paid, booking_date = today)
        $todayBookings = Booking::with(['user', 'field.venue', 'slots'])
            ->where('status', 'paid')
            ->whereDate('booking_date', $todayStr)
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->get()
            ->sortBy(function ($booking) {
                $firstSlot = $booking->slots->sortBy('start_time')->first();
                return $firstSlot ? $firstSlot->start_time : '23:59';
            });

        // 6. Trend Chart (7-day trend of paid bookings count & revenue)
        $chartLabels = [];
        $chartBookings = [];
        $chartRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->toDateString();
            $chartLabels[] = $date->translatedFormat('D, d M');

            $dayBookingsQuery = Booking::where('status', 'paid')
                ->whereDate('booking_date', $dateStr)
                ->when($user->isAdmin(), function ($q) use ($user) {
                    $q->whereHas('field.venue', function ($qv) use ($user) {
                        $qv->where('admin_id', $user->id);
                    });
                });

            $chartBookings[] = $dayBookingsQuery->count();
            $chartRevenue[] = (float) $dayBookingsQuery->sum('total_price');
        }

        return view('admin.dashboard', compact(
            'totalBookingsToday',
            'pendingPayments',
            'liveOccupancy',
            'monthlyRevenue',
            'todayBookings',
            'chartLabels',
            'chartBookings',
            'chartRevenue'
        ));
    }
}
