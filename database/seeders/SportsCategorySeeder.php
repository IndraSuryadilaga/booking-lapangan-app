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
            [
                'name' => 'Futsal',
                'icon' => 'icon/football.svg',
            ],
            [
                'name' => 'Sepak Bola',
                'icon' => 'icon/football.svg',
            ],
            [
                'name' => 'Mini Soccer',
                'icon' => 'icon/football.svg',
            ],
            [
                'name' => 'Basket',
                'icon' => 'icon/basketball.svg',
            ],
            [
                'name' => 'Voli',
                'icon' => 'icon/vollyball.svg',
            ],
            [
                'name' => 'Badminton',
                'icon' => 'icon/badminton.svg',
            ],
            [
                'name' => 'Tenis',
                'icon' => 'icon/badminton.svg',
            ],
            [
                'name' => 'Padel',
                'icon' => 'icon/badminton.svg',
            ],
            [
                'name' => 'Tenis Meja',
                'icon' => 'icon/badminton.svg',
            ],
        ];

        foreach ($categories as $category) {
            SportsCategory::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'is_active' => true,
                ]
            );
        }
    }
}
