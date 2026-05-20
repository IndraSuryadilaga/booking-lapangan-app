<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SportsCategory;

class SportsCategorySeeder extends Seeder
{
    public function run(): void
    {
        SportsCategory::create([
            'name' => 'Futsal'
        ]);

        SportsCategory::create([
            'name' => 'Badminton'
        ]);

        SportsCategory::create([
            'name' => 'Basket'
        ]);
    }
}