<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard aggregates for user and admin.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->route('admin.dashboard');
        }

        // User: total bookings grouped by status
        $bookingsByStatus = Booking::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // User: latest 3 active bookings (pending or confirmed)
        $latestActiveBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('booking_date', 'desc')
            ->take(3)
            ->get();

        $adminBookingsToday = null;

        // Admin: if user administers a venue, count today's bookings scoped to that venue
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            $venue = $user->venue; // relation: hasOne(Venue::class, 'admin_id')

            if ($venue) {
                $adminBookingsToday = Booking::whereHas('field', function ($q) use ($venue) {
                    $q->where('venue_id', $venue->id);
                })->whereDate('booking_date', now()->toDateString())
                  ->count();
            } else {
                $adminBookingsToday = 0;
            }
        }

        return view('dashboard.index', compact('bookingsByStatus', 'latestActiveBookings', 'adminBookingsToday'));
    }
}
