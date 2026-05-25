<?php

namespace Database\Factories;

use App\Models\PublicHoliday;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicHolidayFactory extends Factory
{
    protected $model = PublicHoliday::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true) . ' Day',
            'date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        ];
    }
}
