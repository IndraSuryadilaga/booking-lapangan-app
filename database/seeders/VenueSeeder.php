<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $wifi = Facility::create([
            'name' => 'WiFi',
        ]);

        $parking = Facility::create([
            'name' => 'Parking Area',
        ]);

        $venue = Venue::create([
            'name' => 'Arena Sport Center',
            'slug' => 'arena-sport-center',
            'address' => 'Jl. Sudirman No.1',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
        ]);

        $venue->facilities()->attach([
            $wifi->id,
            $parking->id,
        ]);
    }
}
