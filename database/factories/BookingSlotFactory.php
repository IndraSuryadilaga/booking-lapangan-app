<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingSlotFactory extends Factory
{
    protected $model = BookingSlot::class;

    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('08:00', '21:00');
        $endTime = (clone $startTime)->modify('+1 hour');

        return [
            'booking_id' => Booking::factory(),
            'field_id' => Field::factory(),
            'booking_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'price' => fake()->numberBetween(50000, 200000),
        ];
    }
}
