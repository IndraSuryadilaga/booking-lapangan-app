<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Use DB::raw COUNT(DISTINCT) for reliable distinct field counting on MySQL.
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
            ->count(DB::raw('DISTINCT field_id'));

        // 4. Pendapatan Bulan Ini (status = paid, booking_date in current month)
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth   = now()->endOfMonth()->toDateString();
        $monthlyRevenue = Booking::where('status', 'paid')
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->sum('total_price');

        // 5. Today's Schedule Table — sorted at DB level by earliest slot start_time.
        $todayBookings = Booking::with(['user', 'field.venue', 'slots'])
            ->where('status', 'paid')
            ->whereDate('booking_date', $todayStr)
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->join(
                DB::raw('(SELECT booking_id, MIN(start_time) as first_slot_time FROM booking_slots GROUP BY booking_id) as bslots'),
                'bookings.id',
                '=',
                'bslots.booking_id'
            )
            ->orderBy('bslots.first_slot_time')
            ->select('bookings.*')
            ->get();

        // 6. Trend Chart — single aggregation query replacing 14 individual queries.
        $sevenDaysAgo = now()->subDays(6)->toDateString();

        $trendRows = Booking::where('status', 'paid')
            ->whereBetween('booking_date', [$sevenDaysAgo, $todayStr])
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('field.venue', function ($qv) use ($user) {
                    $qv->where('admin_id', $user->id);
                });
            })
            ->selectRaw('DATE(booking_date) as day, COUNT(*) as total_bookings, SUM(total_price) as total_revenue')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $chartLabels   = [];
        $chartBookings = [];
        $chartRevenue  = [];

        for ($i = 6; $i >= 0; $i--) {
            $date    = now()->subDays($i);
            $dateStr = $date->toDateString();
            $chartLabels[]   = $date->translatedFormat('D, d M');
            $row = $trendRows->get($dateStr);
            $chartBookings[] = $row ? (int) $row->total_bookings : 0;
            $chartRevenue[]  = $row ? (float) $row->total_revenue : 0.0;
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
