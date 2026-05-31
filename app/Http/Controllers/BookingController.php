<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    use AuthorizesRequests;
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function confirm()
    {
        $pendingBooking = session('pending_booking');

        if (!$pendingBooking) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada booking yang sedang diproses.');
        }

        // You would typically pass this data to a confirmation view
        return view('bookings.confirm', ['bookingData' => $pendingBooking]);
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        try {
            $booking = $this->bookingService->createBooking($data);
            // Clear the pending booking from the session
            session()->forget('pending_booking');
            return redirect()->route('bookings.show', $booking)->with('success', 'Booking berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function index(Request $request)
    {
        $query = Booking::where('user_id', auth()->id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->with('field.venue')->latest()->paginate(10);

        return view('bookings.index', ['bookings' => $bookings]);
    }

    public function history()
    {
    $bookings = Booking::where('user_id', auth()->id())
        ->whereIn('status', ['completed', 'cancelled'])
        ->with('field.venue')
        ->latest()
        ->paginate(10);

    return view('bookings.history', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Authorize that the user can view this booking
        $this->authorize('view', $booking);

        $booking->load('field.venue', 'slots', 'payment');

        return view('bookings.show', ['booking' => $booking]);
    }

    public function cancel(Booking $booking)
    {
        // Authorize that the user can cancel this booking
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking dengan status pending yang dapat dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            // The related booking_slots will be deleted automatically by the database cascade rule
            // If not, you would do it here: $booking->slots()->delete();
        });

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }
}
