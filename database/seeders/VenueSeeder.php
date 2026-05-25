<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
feature/2.7-db-fields-module
use App\Models\SportsCategory;
use App\Models\Facility;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil sports category pertama
        $sportsCategory = SportsCategory::first();

        // Kalau belum ada, buat default category
        if (!$sportsCategory) {
            $sportsCategory = SportsCategory::create([
                'name' => 'Futsal',
                'slug' => 'futsal',
                'is_active' => true,
            ]);
        }

        // Facilities
        $wifi = Facility::create([
            'name' => 'WiFi',
            'icon' => 'wifi',
        ]);

        $parking = Facility::create([
            'name' => 'Parking Area',
            'icon' => 'car',
        ]);

        $toilet = Facility::create([
            'name' => 'Toilet',
            'icon' => 'bath',
        ]);

        $canteen = Facility::create([
            'name' => 'Canteen',
            'icon' => 'utensils',
        ]);

        // Venues
        $venues = [
            [
                'name' => 'Arena Sport Center',
                'slug' => 'arena-sport-center',
                'address' => 'Jl. Sudirman No.1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
            ],
            [
                'name' => 'Victory Futsal',
                'slug' => 'victory-futsal',
                'address' => 'Jl. Merdeka No.10',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'name' => 'Champion Arena',
                'slug' => 'champion-arena',
                'address' => 'Jl. Pemuda No.5',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
            [
                'name' => 'Galaxy Sports Hub',
                'slug' => 'galaxy-sports-hub',
                'address' => 'Jl. Melati No.8',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
            ],
            [
                'name' => 'Top Score Arena',
                'slug' => 'top-score-arena',
                'address' => 'Jl. Mawar No.11',
                'city' => 'Semarang',
                'province' => 'Jawa Tengah',
            ],
            [
                'name' => 'Pro Futsal Center',
                'slug' => 'pro-futsal-center',
                'address' => 'Jl. Veteran No.2',
                'city' => 'Malang',
                'province' => 'Jawa Timur',
            ],
            [
                'name' => 'Ultimate Court',
                'slug' => 'ultimate-court',
                'address' => 'Jl. Anggrek No.7',
                'city' => 'Bekasi',
                'province' => 'Jawa Barat',
            ],
            [
                'name' => 'Prime Sports Arena',
                'slug' => 'prime-sports-arena',
                'address' => 'Jl. Kenanga No.15',
                'city' => 'Depok',
                'province' => 'Jawa Barat',
            ],
            [
                'name' => 'Mega Arena Center',
                'slug' => 'mega-arena-center',
                'address' => 'Jl. Diponegoro No.20',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
            ],
        ];

        foreach ($venues as $venueData) {
            $venue = Venue::create($venueData);

            // Attach facilities
            $venue->facilities()->attach([
                $wifi->id,
                $parking->id,
                $toilet->id,
                $canteen->id,
            ]);

            // Attach sports category dynamically
            $venue->sportsCategories()->attach($sportsCategory->id);
        }
    }
}