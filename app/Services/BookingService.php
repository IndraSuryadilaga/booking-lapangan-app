<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Field;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $field = Field::findOrFail($data['field_id']);

            if (!$field->is_active) {
                throw new \Exception('Lapangan sedang ditutup sementara (Maintenance Mode).');
            }

            $bookingDate = Carbon::parse($data['booking_date']);

            if ($bookingDate->isPast()) {
                throw new \Exception('Tidak dapat memesan slot di masa lampau.');
            }

            $dayOfWeek = $bookingDate->dayOfWeek;
            $operatingHours = $field->operatingHours()->where('day_of_week', $dayOfWeek)->first();

            if (!$operatingHours || !$operatingHours->is_open) {
                throw new \Exception('Lapangan tutup pada hari yang dipilih.');
            }

            foreach ($data['slots'] as $slot) {
                $startTime = Carbon::parse($slot['start_time']);
                if ($startTime->lt($operatingHours->open_time) || $startTime->gte($operatingHours->close_time)) {
                    throw new \Exception('Slot yang dipilih di luar jam operasional.');
                }
            }

            $conflict = BookingSlot::where('field_id', $data['field_id'])
                ->where('booking_date', $data['booking_date'])
                ->whereIn('start_time', array_column($data['slots'], 'start_time'))
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                throw new \Exception('Satu atau lebih slot yang Anda pilih baru saja dipesan oleh pengguna lain. Silakan pilih slot lain.');
            }

            $expiresAt = now()->addMinutes(config('booking.expiry_minutes'));

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'field_id' => $data['field_id'],
                'booking_date' => $data['booking_date'],
                'total_slots' => count($data['slots']),
                'total_price' => $data['total_price'],
                'status' => 'pending',
                'expires_at' => $expiresAt,
            ]);


            // 6. Create BookingSlot records
            $bookingSlots = [];

            foreach ($data['slots'] as $slot) {
                $bookingSlots[] = [
                    'booking_id' => $booking->id,
                    'field_id' => $data['field_id'],
                    'booking_date' => $data['booking_date'],
                    'start_time' => $slot['start_time'],
                    'end_time' => \Carbon\Carbon::parse($slot['start_time'])->addHour()->format('H:i:s'),

                    'price' => $slot['price'],
                ];
            }
            BookingSlot::insert($bookingSlots);

            return $booking;
        });
    }
}
