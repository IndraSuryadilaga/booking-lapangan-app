<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;
use App\Models\FieldOperatingHour;
use App\Models\SportsCategory;
use Illuminate\Support\Str;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = SportsCategory::first();

        $field = Field::create([
            'sports_category_id' => $category->id,
            'name' => 'Lapangan Futsal Utama',
            'slug' => Str::slug('Lapangan Futsal Utama') . '-' . uniqid(),
            'description' => 'Lapangan futsal vinyl standar nasional.',
            'price_per_slot' => 100000,
            'photo' => null,
            'is_active' => true,
        ]);

        for ($i = 0; $i <= 6; $i++) {
            FieldOperatingHour::create([
                'field_id' => $field->id,
                'day_of_week' => $i,
                'open_time' => '08:00:00',
                'close_time' => '22:00:00',
                'is_open' => true,
            ]);
        }
    }
}