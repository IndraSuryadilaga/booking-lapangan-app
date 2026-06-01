<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\PublicHoliday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SlotAvailabilityController extends Controller
{
    public function index(Field $field, Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $date = Carbon::parse($validated['date']);

        $cacheKey = "field_{$field->id}_slots_{$date->format('Y-m-d')}";

        $slotsData = Cache::remember($cacheKey, 60, function () use ($field, $date) {
            $dayOfWeek = $date->dayOfWeek;
            $isHoliday = PublicHoliday::where('date', $date->format('Y-m-d'))->exists();
            $isWeekend = $date->isSaturday() || $date->isSunday();

            $dayType = 'regular';
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

            $pricing = $field->pricings()->where('tier', $dayType)->first();
            $price = $pricing ? $pricing->price : $field->pricings()->where('tier', 'regular')->first()->price;

            $startTime = Carbon::parse($operatingHour->start_time);
            $endTime = Carbon::parse($operatingHour->end_time);
            $slotDuration = config('app.slot_duration', 60);

            $slots = [];
            $bookedSlots = $field->bookingSlots()
                ->where('date', $date->format('Y-m-d'))
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
