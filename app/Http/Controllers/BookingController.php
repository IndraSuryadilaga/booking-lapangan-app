<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function confirm(Request $request)
    {
        if ($request->has('field_id')) {
            $request->validate([
                'field_id' => 'required|exists:fields,id',
                'date' => 'required|date|after_or_equal:today|before_or_equal:+60 days',
                'slots' => 'required|array|min:1',
            ]);

            $field = \App\Models\Field::findOrFail($request->field_id);
            if (!$field->is_active) {
                return redirect()->route('dashboard')->with('error', 'Lapangan sedang ditutup sementara (Maintenance Mode).');
            }

            $slotsMapped = collect($request->slots)->map(function($slot) {
                return [
                    'start_time' => $slot['start'] . ':00',
                    'end_time' => $slot['end'] . ':00',
                    'price' => $slot['price'],
                ];
            })->toArray();

            $totalPrice = collect($request->slots)->sum('price');

            $pendingBooking = [
                'field_id' => $request->field_id,
                'booking_date' => $request->date,
                'slots' => $slotsMapped,
                'total_price' => $totalPrice,
            ];

            session(['pending_booking' => $pendingBooking]);
        }

        $pendingBooking = session('pending_booking');

        if (!$pendingBooking) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada booking yang sedang diproses.');
        }

        $field = \App\Models\Field::with('venue')->findOrFail($pendingBooking['field_id']);

        if (!$field->is_active) {
            session()->forget('pending_booking');
            return redirect()->route('dashboard')->with('error', 'Lapangan sedang ditutup sementara (Maintenance Mode).');
        }

        return view('bookings.confirm', [
            'bookingData' => $pendingBooking,
            'field' => $field
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        try {
            $booking = $this->bookingService->createBooking($data);

            session()->forget('pending_booking');

            return redirect()->route('payments.show', $booking)->with('success', 'Pesanan dibuat. Silakan selesaikan pembayaran.');

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
        $bookings = Booking::with(['field.venue', 'payment'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['paid', 'confirmed', 'completed', 'cancelled', 'expired'])
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        $booking->load(['field.venue', 'slots', 'payment']);

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking dengan status pending yang dapat dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            $booking->slots()->delete();
        });

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function init(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'slots' => 'required|array|min:1',
        ]);

        $slotsData = $request->slots;
        $fieldId = array_key_first($slotsData);
        $rawSlots = $slotsData[$fieldId];

        $selectedSlots = [];
        foreach ($rawSlots as $item) {
            $parts = explode('|', $item);
            $selectedSlots[] = [
                'time' => $parts[0],
                'price' => isset($parts[1]) ? (int)$parts[1] : 0
            ];
        }

        session(['pending_booking' => [
            'field_id' => $fieldId,
            'booking_date' => $request->booking_date,
            'slots' => $selectedSlots,
        ]]);

        return redirect()->route('bookings.confirm');
    }
}
