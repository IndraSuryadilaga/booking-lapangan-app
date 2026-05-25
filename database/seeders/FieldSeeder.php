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
        // Retrieve the first venue and sports category from the database
        $venue = Venue::first();
        $category = SportsCategory::first();

        // Prevent seeding if dependencies are missing
        if (!$venue || !$category) {
            $this->command->info('Please seed Venue and SportsCategory tables first.');
            return;
        }

        // 1. Create a dummy field attached to the first venue
        $field = Field::create([
            'venue_id'           => $venue->id,
            'sports_category_id' => $category->id,
            'name'               => 'Main Indoor Futsal Court',
            'slug'               => 'main-indoor-futsal-court',
            'description'        => 'High-quality vinyl indoor futsal court with excellent lighting.',
            'type'               => 'indoor',
            'surface_material'   => 'Vinyl',
            'is_active'          => true,
        ]);

        // 2. Seed field images (setting the first one as primary)
        $field->images()->create([
            'image_path' => 'fields/dummy-field-1.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        // 3. Seed operating hours for 7 days (0 = Sunday to 6 = Saturday)
        for ($i = 0; $i <= 6; $i++) {
            $field->operatingHours()->create([
                'day_of_week' => $i,
                'open_time'   => '08:00:00',
                'close_time'  => '23:00:00',
                'is_open'     => true,
            ]);
        }

        // 4. Seed pricing schemes (weekday, weekend, holiday)
        $pricingSchemes = [
            'weekday' => 100000, // Rp 100.000
            'weekend' => 150000, // Rp 150.000
            'holiday' => 200000, // Rp 200.000
        ];

        foreach ($pricingSchemes as $dayType => $price) {
            $field->pricing()->create([
                'day_type'       => $dayType,
                'price_per_slot' => $price,
            ]);
        }
    }
}