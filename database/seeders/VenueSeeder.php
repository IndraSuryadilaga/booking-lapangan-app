<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\SportsCategory;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = User::where('role', 'admin')->get();
        $facilities = Facility::all();
        $sportsCategories = SportsCategory::all();

        $venueImages = [
            'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=800',
            'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800',
            'https://images.unsplash.com/photo-1544698310-74ea9d1c8258?w=800',
            'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800',
            'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=800',
        ];

        $venuesData = [
            [
                'name' => 'Arena Sport Center',
                'address' => 'Jl. Sudirman No.1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
            ],
            [
                'name' => 'Victory Futsal',
                'address' => 'Jl. Merdeka No.10',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'name' => 'Skyline Rooftop Hoops',
                'address' => 'Jl. Thamrin No.55',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
            [
                'name' => 'Grand Slam Tennis Arena',
                'address' => 'Jl. Gatsu No.12',
                'city' => 'Denpasar',
                'province' => 'Bali',
            ],
            [
                'name' => 'Green Pitch Soccer Field',
                'address' => 'Jl. Malioboro No.8',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
            ],
        ];

        foreach ($venuesData as $index => $data) {
            $currentAdmin = $admins->get($index);

            $venue = Venue::create([
                'admin_id' => $currentAdmin ? $currentAdmin->id : null,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'address' => $data['address'],
                'city' => $data['city'],
                'province' => $data['province'],
                'image_path' => $venueImages[$index] ?? $venueImages[0],
                'is_active' => true,
            ]);

            if ($facilities->count() > 0) {
                $venue->facilities()->attach($facilities->random(rand(2, 4))->pluck('id'));
            }

            if ($sportsCategories->count() > 0) {
                $venue->sportsCategories()->attach($sportsCategories->random(rand(1, 2))->pluck('id'));
            }
        }
    }
}
