<?php

namespace Database\Factories;

use App\Models\BookingSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingSlotFactory extends Factory
{
    protected $model = BookingSlot::class;

    public function definition(): array
    {
        return [
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'price' => fake()->numberBetween(5, 15) * 10000,
        ];
    }
}
