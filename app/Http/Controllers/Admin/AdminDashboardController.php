<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $todayStr = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        $adminFieldIds = [];
        if ($user->role === 'admin') {
            $adminFieldIds = DB::table('fields')
                ->join('venues', 'fields.venue_id', '=', 'venues.id')
                ->where('venues.admin_id', $user->id)
                ->pluck('fields.id')
                ->toArray();

            if (empty($adminFieldIds)) {
                return $this->emptyDashboardResponse();
            }
        }

        $applyAdminFilter = function ($query) use ($user, $adminFieldIds) {
            $query->when($user->role === 'admin', fn($q) => $q->whereIn('field_id', $adminFieldIds));
        };

        $totalBookingsToday = Booking::where('status', 'paid')
            ->where('booking_date', $todayStr)
            ->tap($applyAdminFilter)
            ->count();

        $pendingPayments = Booking::where('status', 'pending')
            ->tap($applyAdminFilter)
            ->count();

        $liveOccupancy = BookingSlot::where('booking_date', $todayStr)
            ->where('start_time', '<=', $nowTime)
            ->where('end_time', '>', $nowTime)
            ->whereHas('booking', function ($q) use ($applyAdminFilter) {
                $q->where('status', 'paid')->tap($applyAdminFilter);
            })
            ->distinct('field_id')
            ->count('field_id');

        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth   = now()->endOfMonth()->toDateString();

        $monthlyRevenue = Booking::where('status', 'paid')
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->tap($applyAdminFilter)
            ->sum('total_price');

        $todayBookings = Booking::with(['user', 'field.venue', 'slots'])
            ->where('status', 'paid')
            ->where('booking_date', $todayStr)
            ->tap($applyAdminFilter)
            ->addSelect(['first_slot_time' => BookingSlot::select('start_time')
                ->whereColumn('booking_id', 'bookings.id')
                ->orderBy('start_time', 'asc')
                ->limit(1)
            ])
            ->orderBy('first_slot_time')
            ->get();

        $sevenDaysAgo = now()->subDays(6)->toDateString();

        $trendRows = Booking::where('status', 'paid')
            ->whereBetween('booking_date', [$sevenDaysAgo, $todayStr])
            ->tap($applyAdminFilter)
            ->selectRaw('booking_date as day, COUNT(*) as total_bookings, SUM(total_price) as total_revenue')
            ->groupBy('booking_date')
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

    /**
     * Helper response ketika Admin belum punya lapangan
     */
    private function emptyDashboardResponse()
    {
        return view('admin.dashboard', [
            'totalBookingsToday' => 0,
            'pendingPayments' => 0,
            'liveOccupancy' => 0,
            'monthlyRevenue' => 0,
            'todayBookings' => collect(),
            'chartLabels' => array_fill(0, 7, ''),
            'chartBookings' => array_fill(0, 7, 0),
            'chartRevenue' => array_fill(0, 7, 0.0)
        ]);
    }
}
