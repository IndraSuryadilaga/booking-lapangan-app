<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Booking::with(['user', 'field.venue']);

        if ($user->isSuperAdmin()) {
            // No additional filtering needed
        }
        // Admin sees bookings for their own venue
        elseif ($user->isAdmin() && $user->hasVenue()) {
            $venueId = $user->venue->id;
            $query->whereHas('field', function ($q) use ($venueId) {
                $q->where('venue_id', $venueId);
            });
        } else {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('field_id')) {
            $query->where('field_id', $request->field_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $bookings = $query->latest()->paginate(15);

        // Fetch fields list for the dropdown filter
        $fields = \App\Models\Field::when($user->isAdmin(), function ($q) use ($user) {
            $q->whereHas('venue', fn ($qv) => $qv->where('admin_id', $user->id));
        })->get();

        return view('admin.bookings.index', compact('bookings', 'fields'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorizeAdminAccess($booking);
        $booking->load(['user', 'field.venue', 'slots', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the status of the specified booking in storage.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $this->authorizeAdminAccess($booking);

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled,expired',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Authorize that the admin can access the booking.
     */
    private function authorizeAdminAccess(Booking $booking)
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            return;
        }

        if ($user->isAdmin() && $user->hasVenue() && $booking->field->venue_id === $user->venue->id) {
            return;
        }

        abort(403, 'Anda tidak memiliki izin untuk melihat booking ini.');
    }
}
