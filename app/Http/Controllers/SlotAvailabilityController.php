<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\PublicHoliday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SlotAvailabilityController extends Controller
{
    public function index($fieldId, Request $request)
    {
        $field = Field::findOrFail($fieldId);

        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:+60 days'],
        ]);

        $date = Carbon::parse($validated['date']);

        if (!$field->is_active) {
            return response()->json([
                'date' => $date->format('Y-m-d'),
                'is_open' => false,
                'slots' => [],
                'message' => 'Lapangan sedang ditutup sementara (Maintenance Mode).',
            ]);
        }

        $cacheKey = "field_{$field->id}_slots_{$date->format('Y-m-d')}";

        $slotsData = Cache::remember($cacheKey, 60, function () use ($field, $date) {
            $dayOfWeek = $date->dayOfWeek;
            $isHoliday = PublicHoliday::where('holiday_date', $date->format('Y-m-d'))->exists();
            $isWeekend = $date->isSaturday() || $date->isSunday();

            $dayType = 'weekday';
            if ($isHoliday) {
                $dayType = 'holiday';
            } elseif ($isWeekend) {
                $dayType = 'weekend';
            }

            $operatingHour = $field->operatingHours()->where('day_of_week', $dayOfWeek)->first();

            if (!$operatingHour || !$operatingHour->is_open) {
                return [
                    'date' => $date->format('Y-m-d'),
                    'day_type' => $dayType,
                    'is_open' => false,
                    'slots' => [],
                ];
            }

            // Menggunakan pricings() (plural) dan nama kolom yang benar
            $pricing = $field->pricings()->where('day_type', $dayType)->first();
            $price = $pricing ? $pricing->price_per_slot : $field->pricings()->where('day_type', 'weekday')->first()->price_per_slot;

            $startTime = Carbon::parse($operatingHour->open_time);
            $endTime = Carbon::parse($operatingHour->close_time);
            $slotDuration = config('app.slot_duration', 60);

            $slots = [];
            $bookedSlots = $field->bookingSlots()
                ->where('booking_date', $date->format('Y-m-d'))
                ->pluck('start_time')
                ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();

            while ($startTime < $endTime) {
                $slotStart = $startTime->format('H:i');
                $slotEnd = $startTime->addMinutes($slotDuration)->format('H:i');

                $slots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'status' => in_array($slotStart, $bookedSlots) ? 'booked' : 'available',
                    'price' => $price,
                ];
            }

            return [
                'date' => $date->format('Y-m-d'),
                'day_type' => $dayType,
                'is_open' => true,
                'slots' => $slots,
            ];
        });

        return response()->json($slotsData);
    }
}
