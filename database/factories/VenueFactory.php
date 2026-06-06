<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VenueFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company() . ' Sport Center';

        $venueLogos = [
            'https://images.unsplash.com/photo-1504450758481-7338eba7524a?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1626003573503-2e088d82c647?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://plus.unsplash.com/premium_photo-1668051040456-24c63abd95b4?q=80&w=676&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1734714555326-d42a7a9f9728?q=80&w=626&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1750049790142-2db418e5745c?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1661400191297-b0d09043c09a?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1632342664765-b067a9e89a44?q=80&w=726&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1565483276107-8a1fbf01ab03?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1577214250144-73af4b7364f6?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=600&h=600&fit=crop',
        ];

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->lexify('????')),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'latitude' => fake()->latitude(-10, 5),
            'longitude' => fake()->longitude(95, 140),
            'logo' => fake()->randomElement($venueLogos),
            'is_active' => fake()->boolean(90),
        ];
    }
}
