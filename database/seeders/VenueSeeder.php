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
        $admins = User::where('role', 'admin')->take(2)->get();
        if ($admins->count() < 2) {
            $this->command->error('Please seed at least two admin users before running VenueSeeder.');
            $admins = User::factory()->count(2)->create(['role' => 'admin']);
        }

        $facilities = Facility::take(4)->get();
        $sportsCategories = SportsCategory::take(2)->get();

        $venue1 = Venue::create([
            'admin_id' => $admins[0]->id,
            'name' => 'Arena Sport Center',
            'slug' => 'arena-sport-center',
            'address' => 'Jl. Sudirman No.1',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
        ]);

        $venue1->facilities()->attach($facilities->pluck('id'));
        $venue1->sportsCategories()->attach($sportsCategories->pluck('id'));

        $venue2 = Venue::create([
            'admin_id' => $admins[1]->id,
            'name' => 'Victory Futsal',
            'slug' => 'victory-futsal',
            'address' => 'Jl. Merdeka No.10',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
        ]);

        $venue2->facilities()->attach($facilities->random(2)->pluck('id'));
        $venue2->sportsCategories()->attach($sportsCategories->random(1)->pluck('id'));
    }
}
