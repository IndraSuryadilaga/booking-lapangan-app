<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'amount' => fake()->randomFloat(2, 50000, 500000),
            'method' => fake()->randomElement(['bank_transfer', 'credit_card', 'e-wallet']),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'paid_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'reference_code' => strtoupper(fake()->bothify('PAY-#####-????')),
        ];
    }
}
