<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Booking::with(['user', 'field.venue']);

        if ($user->isSuperAdmin()) {
        } elseif ($user->isAdmin() && $user->hasVenue()) {
            $fieldIds = Field::where('venue_id', $user->venue->id)->pluck('id');
            $query->whereIn('field_id', $fieldIds);
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

        $fields = Field::select('id', 'name')
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->where('venue_id', $user->venue->id ?? 0);
            })->get();

        return view('admin.bookings.index', compact('bookings', 'fields'));
    }

    public function show(Booking $booking)
    {
        $this->authorizeAdminAccess($booking);
        $booking->load(['user', 'field.venue', 'slots', 'payment']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $this->authorizeAdminAccess($booking);

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled,expired',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Status booking berhasil diperbarui.');
    }

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
