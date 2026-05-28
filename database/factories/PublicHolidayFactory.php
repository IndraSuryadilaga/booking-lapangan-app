<?php

namespace Database\Factories;

use App\Models\PublicHoliday;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PublicHolidayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PublicHoliday::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Tahun Baru', 'Hari Raya Nyepi', 'Wafat Isa Al Masih', 'Hari Buruh',
                'Kenaikan Isa Al Masih', 'Hari Lahir Pancasila', 'Idul Adha',
                'Tahun Baru Islam', 'Maulid Nabi Muhammad SAW', 'Natal'
            ]),
            'date' => $this->faker->unique()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        ];
    }
}
