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

        $venueLogos = [
            'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=150&h=150&fit=crop',
        ];

        $venuesData = [
            [
                'name' => 'Arena Sport Center',
                'address' => 'Jl. Sudirman No.1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'latitude' => -6.2087634,
                'longitude' => 106.8222588,
            ],
            [
                'name' => 'Victory Futsal',
                'address' => 'Jl. Merdeka No.10',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'latitude' => -6.9116716,
                'longitude' => 107.6136511,
            ],
            [
                'name' => 'Skyline Rooftop Hoops',
                'address' => 'Jl. Thamrin No.55',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'latitude' => -7.2736465,
                'longitude' => 112.7397782,
            ],
            [
                'name' => 'Grand Slam Tennis Arena',
                'address' => 'Jl. Gatsu No.12',
                'city' => 'Denpasar',
                'province' => 'Bali',
                'latitude' => -8.6358178,
                'longitude' => 115.2136015,
            ],
            [
                'name' => 'Green Pitch Soccer Field',
                'address' => 'Jl. Malioboro No.8',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'latitude' => -7.7925763,
                'longitude' => 110.3658602,
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
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'logo' => $venueLogos[$index] ?? $venueLogos[0],
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
