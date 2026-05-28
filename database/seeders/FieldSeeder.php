<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = Venue::take(2)->get();
        $category = SportsCategory::first();

        if ($venues->count() < 2 || !$category) {
            $this->command->info('Please seed at least 2 Venues and 1 SportsCategory before running FieldSeeder.');
            return;
        }

        $venues->each(function ($venue, $venueIndex) use ($category) {
            for ($i = 1; $i <= 2; $i++) {
                $fieldNumber = ($venueIndex * 2) + $i;
                $field = Field::create([
                    'venue_id' => $venue->id,
                    'sports_category_id' => $category->id,
                    'name' => "Field {$fieldNumber} - {$venue->name}",
                    'slug' => "field-{$fieldNumber}-{$venue->slug}",
                    'description' => 'A great field for your sporting needs.',
                    'type' => $i % 2 == 0 ? 'indoor' : 'outdoor',
                    'surface_material' => 'Grass',
                    'is_active' => true,
                ]);

                $field->images()->create([
                    'image_path' => "fields/dummy-field-{$field->id}.jpg",
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);

                for ($day = 0; $day <= 6; $day++) {
                    $field->operatingHours()->create([
                        'day_of_week' => $day,
                        'open_time' => '07:00:00',
                        'close_time' => '22:00:00',
                        'is_open' => true,
                    ]);
                }

                $pricing = [
                    'weekday' => 120000,
                    'weekend' => 180000,
                    'holiday' => 220000,
                ];

                foreach ($pricing as $dayType => $price) {
                    $field->pricing()->create([
                        'day_type' => $dayType,
                        'price_per_slot' => $price,
                    ]);
                }
            }
        });
    }
}
