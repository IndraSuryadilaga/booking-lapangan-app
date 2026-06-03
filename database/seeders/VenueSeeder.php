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
        // Pastikan ada admin[cite: 4]
        $admins = User::where('role', 'admin')->get();
        if ($admins->count() < 1) {
            $this->command->error('Please seed at least one admin user before running VenueSeeder.');
            $admins = User::factory()->count(2)->create(['role' => 'admin']);
        }

        $facilities = Facility::all();
        $sportsCategories = SportsCategory::all();

        // Data Venues tambahan
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

        foreach ($venuesData as $data) {
            $venue = Venue::create([
                'admin_id' => $admins->random()->id, // Assign ke admin secara acak
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'address' => $data['address'],
                'city' => $data['city'],
                'province' => $data['province'],
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
