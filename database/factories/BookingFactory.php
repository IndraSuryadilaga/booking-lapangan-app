<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'field_id' => Field::factory(),
            'booking_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'total_slots' => fake()->numberBetween(1, 3),
            'total_price' => fake()->numberBetween(50000, 500000),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
            'expires_at' => now()->addHours(2),
        ];
    }
}
