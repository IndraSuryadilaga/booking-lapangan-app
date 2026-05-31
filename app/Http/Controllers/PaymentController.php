<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the payment page for a specific booking.
     */
    public function show(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)->with('info', 'Booking ini sudah tidak dapat dibayar.');
        }

        // If booking has expired
        if ($booking->expires_at->isPast()) {
            $booking->update(['status' => 'expired']);
            return redirect()->route('bookings.show', $booking)->with('error', 'Waktu pembayaran untuk booking ini telah habis.');
        }

        $booking->load('field.venue');

        return view('payments.show', compact('booking'));
    }

    /**
     * Process the payment for a booking.
     */
    public function process(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)->with('error', 'Pembayaran tidak dapat diproses.');
        }

        try {
            DB::transaction(function () use ($booking) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'status' => 'success',
                    'reference_code' => 'PAY-' . strtoupper(Str::random(10)),
                    'paid_at' => now(),
                    'amount' => $booking->total_price,
                    'method' => 'virtual_account',
                ]);

                $booking->update([
                    'status' => 'paid',
                    'expires_at' => null,
                ]);
            });

            return redirect()->route('bookings.show', $booking)->with('success', 'Pembayaran berhasil! Booking Anda telah dikonfirmasi.');

        } catch (\Exception $e) {
            logger()->error('Payment processing failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }
}
