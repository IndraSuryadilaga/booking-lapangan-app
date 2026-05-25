<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FieldFactory extends Factory
{
    protected $model = Field::class;

    public function definition(): array
    {
        $name = fake()->word . ' Field';

        return [
            'venue_id' => Venue::factory(),
            'sports_category_id' => SportsCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->word),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['indoor', 'outdoor', 'semi-indoor']),
            'surface_material' => fake()->word(),
            'is_active' => fake()->boolean(),
        ];
    }
}
