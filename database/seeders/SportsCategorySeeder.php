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
                'icon' => 'images/sports-icon/futsal-icon.png',
            ],
            [
                'name' => 'Badminton',
                'icon' => 'images/sports-icon/badminton-icon.png',
            ],
            [
                'name' => 'Basket',
                'icon' => 'images/sports-icon/basket-icon.png',
            ],
            [
                'name' => 'Voli',
                'icon' => 'images/sports-icon/voli-icon.png',
            ],
            [
                'name' => 'Tenis',
                'icon' => 'images/sports-icon/tenis-icon.png',
            ],
            [
                'name' => 'Mini Soccer',
                'icon' => 'images/sports-icon/minisoccer-icon.png',
            ],
            [
                'name' => 'Sepak Bola',
                'icon' => 'images/sports-icon/sepakbola-icon.png',
            ],
            [
                'name' => 'Padel',
                'icon' => 'images/sports-icon/padel-icon.png',
            ],
            [
                'name' => 'Tenis Meja',
                'icon' => 'images/sports-icon/tenismeja-icon.png',
            ],
            [
                'name' => 'Billiard',
                'icon' => 'images/sports-icon/billiard-icon.pngg',
            ],
        ];

        foreach ($categories as $category) {
            SportsCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'is_active' => true,
            ]);
        }
    }
}