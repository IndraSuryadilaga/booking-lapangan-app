<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SportsCategory;
use Illuminate\Support\Str;

class SportsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Futsal',
            'Badminton',
            'Basket',
        ];

        foreach ($categories as $category) {
            SportsCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'icon' => null,
                'is_active' => true,
            ]);
        }
    }
}