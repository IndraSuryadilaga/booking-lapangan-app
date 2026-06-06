<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FieldFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->randomElement(['Arena', 'Court', 'Pitch', 'Field']) . ' ' . fake()->firstName();

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->lexify('????')),
            'description' => 'A great, high-quality field for your sporting needs. Completely equipped and well maintained.',
            'type' => fake()->randomElement(['indoor', 'outdoor', 'semi-indoor']),
            'surface_material' => fake()->randomElement(['Grass', 'Synthetic', 'Vinyl', 'Parquet', 'Concrete']),
            'is_active' => true,
        ];
    }
}
