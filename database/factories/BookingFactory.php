<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'booking_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'total_slots' => 0,
            'total_price' => 0,
            'status' => fake()->randomElement(['pending', 'paid', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
            'expires_at' => now()->addHours(2),
        ];
    }
}
