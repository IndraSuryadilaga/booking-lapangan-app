<?php
namespace Database\Seeders;

use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = Venue::all();
        $categories = SportsCategory::all();

        if ($venues->count() < 1 || $categories->count() < 1) {
            $this->command->info('Please seed Venues and SportsCategories before running FieldSeeder.');
            return;
        }

        $unsplashIds = [
            'tennis' => ['sbjPmjwCtQo', 'dFJFwlGtFl0', 'G9Gw1_vFHbo', 'yoIt3Wxe0sI'],
            'basketball' => ['hAr9Nlo2Fz4', 'HZzNCojYV0k', 'XcBPc0Q_2h8', 'XmYSlYrupL8', 'UQpTP-KqYRk', 'J_tbkGWxCH0', 'KDxFq4_SWSg', 'ece3HWGHdl0'],
            'soccer' => ['K5ChxJaheKI', 'tGr0i7ooQeA']
        ];

        $allImages = array_merge($unsplashIds['tennis'], $unsplashIds['basketball'], $unsplashIds['soccer']);

        $venues->each(function ($venue, $venueIndex) use ($categories, $allImages) {

            $numberOfFields = rand(3, 4);

            for ($i = 1; $i <= $numberOfFields; $i++) {
                $category = $categories->random();
                $fieldNumber = ($venueIndex * 5) + $i;
                $fieldName = "Field {$fieldNumber} - {$venue->name}";

                $field = Field::create([
                    'venue_id' => $venue->id,
                    'sports_category_id' => $category->id,
                    'name' => $fieldName,
                    'slug' => Str::slug($fieldName),
                    'description' => 'A great, high-quality field for your sporting needs. Completely equipped and well maintained.',
                    'type' => rand(0, 1) ? 'indoor' : 'outdoor',
                    'surface_material' => rand(0, 1) ? 'Grass' : 'Synthetic',
                    'is_active' => true,
                ]);

                $randomImageId = $allImages[array_rand($allImages)];
                $unsplashUrl = "https://source.unsplash.com/{$randomImageId}/800x600";

                $field->images()->create([
                    'image_path' => $unsplashUrl,
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
                    'weekday' => rand(10, 15) * 10000,
                    'weekend' => rand(15, 20) * 10000,
                    'holiday' => rand(20, 25) * 10000,
                ];

                foreach ($pricing as $dayType => $price) {
                    $field->pricings()->create([
                        'day_type' => $dayType,
                        'price_per_slot' => $price, // Set harga per slot[cite: 3]
                    ]);
                }
            }
        });
    }
}
