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
                'icon' => 'images/sports/futsal.png',
            ],
            [
                'name' => 'Badminton',
                'icon' => 'images/sports/badminton.jpg',
            ],
            [
                'name' => 'Basket',
                'icon' => 'images/sports/basket.jpg',
            ],
            [
                'name' => 'Voli',
                'icon' => 'images/sports/voli.jpg',
            ],
            [
                'name' => 'Tenis',
                'icon' => 'images/sports/tenis.jpg',
            ],
            [
                'name' => 'Mini Soccer',
                'icon' => 'images/sports/minisoccer.jpg',
            ],
            [
                'name' => 'Sepak Bola',
                'icon' => 'images/sports/sepakbola.png',
            ],
            [
                'name' => 'Padel',
                'icon' => 'images/sports/padel.png',
            ],
            [
                'name' => 'Tenis Meja',
                'icon' => 'images/sports/tenismeja.jpg',
            ],
            [
                'name' => 'Billiard',
                'icon' => 'images/sports/billiard.jpg',
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