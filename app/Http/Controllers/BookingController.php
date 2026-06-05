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

    public function confirm()
    {
        $pendingBooking = session('pending_booking');

        if (!$pendingBooking) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada booking yang sedang diproses.');
        }

        $field = \App\Models\Field::with('venue')->findOrFail($pendingBooking['field_id']);

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

            // Hapus keranjang
            session()->forget('pending_booking');

            // UBAH BARIS INI: Arahkan ke halaman Pembayaran, bukan langsung ke tiket
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

    /**
     * Display a listing of the user's booking history.
     */
    /**
     * Display a listing of the user's booking history.
     */
    public function history()
    {
        $bookings = Booking::with(['field.venue', 'payment'])
            ->where('user_id', auth()->id())
            // PERUBAHAN: Memasukkan paid dan confirmed agar tiket aktif juga muncul
            ->whereIn('status', ['paid', 'confirmed', 'completed', 'cancelled', 'expired'])
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    /**
     * Display the specified booking (E-Ticket / Invoice).
     */
    public function show(Booking $booking)
    {
        // Pastikan hanya pemilik yang bisa melihat tiketnya
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        // Load relasi lengkap untuk e-tiket
        $booking->load(['field.venue', 'slots', 'payment']);

        return view('bookings.show', compact('booking'));
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

        // Pecah gabungan "Jam|Harga" menjadi array terpisah
        $selectedSlots = [];
        foreach ($rawSlots as $item) {
            $parts = explode('|', $item);
            $selectedSlots[] = [
                'time' => $parts[0],                 // Jam (misal: 19:00)
                'price' => isset($parts[1]) ? (int)$parts[1] : 0 // Harga (misal: 130000)
            ];
        }

        session(['pending_booking' => [
            'field_id' => $fieldId,
            'booking_date' => $request->booking_date,
            'slots' => $selectedSlots, // Sekarang formatnya sudah rapi
        ]]);

        return redirect()->route('bookings.confirm');
    }
}
