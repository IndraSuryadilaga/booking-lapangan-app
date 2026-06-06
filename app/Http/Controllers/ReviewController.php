<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show form to create a review for a booking.
     */
    public function create(Booking $booking)
    {
        $user = Auth::user();

        // Booking must belong to authenticated user
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        // Booking must be completed
        if ($booking->status !== 'completed') {
            return redirect()->route('bookings.history')->with('error', 'You can only review completed bookings.');
        }

        // Prevent duplicate review per booking
        if ($booking->review()->exists()) {
            // UBAH: Jangan gunakan back(), arahkan ke route riwayat
            return redirect()->route('bookings.history')->with('error', 'This booking has already been reviewed.');
        }

        // Render review form
        return view('reviews.create', compact('booking'));
    }

    /**
     * Store a review for a booking.
     */
    public function store(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // Booking must belong to authenticated user
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        // Booking must be completed
        if ($booking->status !== 'completed') {
            return redirect()->route('bookings.history')->with('error', 'You can only review completed bookings.');
        }

        // Prevent duplicate review submission (defensive)
        if ($booking->review()->exists()) {
            return redirect()->route('bookings.history')->with('error', 'This booking has already been reviewed.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string'],
        ]);

        // Ensure field relation is available for venue linkage
        $booking->load('field');

        Review::create([
            'user_id' => $user->id,
            'venue_id' => $booking->field?->venue_id,
            'field_id' => $booking->field_id,
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // UBAH: Arahkan user ke halaman riwayat setelah sukses submit
        return redirect()->route('bookings.history')->with('success', 'Thank you for your review.');
    }
}
