<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Toilet',
                'icon' => 'images/facilities/toilet.jpg',
            ],
            [
                'name' => 'Parkir',
                'icon' => 'images/facilities/parkir.jpg',
            ],
            [
                'name' => 'Mushola',
                'icon' => 'images/facilities/mushola.png',
            ],
            [
                'name' => 'Kantin',
                'icon' => 'images/facilities/kantin.jpg',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}