<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldOperatingHour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $field = Field::create([
            'name' => 'Arena Futsal Merdeka',
            'slug' => Str::slug('Arena Futsal Merdeka'),
            'category' => 'Futsal',
            'location' => 'Jl. Merdeka No. 10',
            'price_per_slot' => 80000,
            'description' => 'Lapangan futsal dengan rumput sintetis standar internasional, fasilitas ruang ganti, dan pencahayaan lampu LED yang terang.',
            'image' => 'futsal-merdeka.jpg',
            'is_active' => true,
        ]);

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($days as $day) {
            FieldOperatingHour::create([
                'field_id' => $field->id,
                'day_of_week' => $day,
                'open_time' => '08:00:00',  
                'close_time' => '22:00:00', 
                'is_closed' => false,
            ]);
        }
    }
}
