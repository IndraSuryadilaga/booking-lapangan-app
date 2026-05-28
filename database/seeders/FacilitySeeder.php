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
                'icon' => 'icon/toilet.svg',
            ],
            [
                'name' => 'Cafe & Resto',
                'icon' => 'icon/cafe-resto.svg',
            ],
            [
                'name' => 'Changing Room',
                'icon' => 'icon/user.svg',
            ],
            [
                'name' => 'Free WiFi',
                'icon' => 'icon/wifi.svg',
            ],
            [
                'name' => 'Parking Car',
                'icon' => 'icon/parking-car.svg',
            ],
            [
                'name' => 'Shower',
                'icon' => 'icon/shower.svg',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(
                ['name' => $facility['name']],
                ['icon' => $facility['icon']]
            );
        }
    }
}
