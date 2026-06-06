<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\SportsCategory;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilityIds = Facility::pluck('id');
        $sportsCategoryIds = SportsCategory::pluck('id');

        $totalData = 30;

        $this->command->info("Men-generate {$totalData} data Venue & Admin baru...");

        Venue::factory($totalData)
            ->state(function () {
                return [
                    'admin_id' => User::factory()->create(['role' => 'admin'])->id,
                ];
            })
            ->create()
            ->each(function ($venue) use ($facilityIds, $sportsCategoryIds) {
                if ($facilityIds->isNotEmpty()) {
                    $venue->facilities()->attach($facilityIds->random(rand(2, 4)));
                }

                if ($sportsCategoryIds->isNotEmpty()) {
                    $venue->sportsCategories()->attach($sportsCategoryIds->random(rand(1, 2)));
                }
            });

        $this->command->info("Seeding {$totalData} Venue selesai dengan aman!");
    }
}
