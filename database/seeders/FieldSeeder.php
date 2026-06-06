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
        $venueIds = Venue::pluck('id');
        $categoryIds = SportsCategory::pluck('id');

        if ($venueIds->isEmpty() || $categoryIds->isEmpty()) {
            $this->command->error('Venues atau SportsCategories masih kosong! Silakan seed terlebih dahulu.');
            return;
        }

        $unsplashUrls = [
            'https://images.unsplash.com/photo-1729843352938-0e10fbf96585?q=80&w=1400&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1636959961919-985cbee8d6d9?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1765599020795-d203ff66e400?q=80&w=1121&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1572454181157-0b40dd7667fe?q=80&w=1201&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1719959396334-d086d719ffc8?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1578966663421-00f3bfebfa89?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1567220720374-a67f33b2a6b9?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1564769353575-73f33a36d84f?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1635842939844-1fbf6bea8e78?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1689942963385-f5bd03f3b270?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1709587824751-dd30420f5cf3?q=80&w=1331&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1709587824645-cf6dd2041e2b?q=80&w=1331&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1731221180372-57e35146bf20?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1697864810151-cceeb09b5239?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1771909712463-b1c7b542f845?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?w=800&h=600&fit=crop',
        ];

        $this->command->info("Men-generate 3-4 Lapangan untuk setiap Venue...");

        foreach ($venueIds as $venueId) {
            $numberOfFields = rand(3, 4);

            Field::factory($numberOfFields)
                ->state(function () use ($venueId, $categoryIds) {
                    return [
                        'venue_id' => $venueId,
                        'sports_category_id' => $categoryIds->random(),
                    ];
                })
                ->create()
                ->each(function ($field) use ($unsplashUrls) {

                    $field->images()->create([
                        'image_path' => $unsplashUrls[array_rand($unsplashUrls)],
                        'is_primary' => true,
                        'sort_order' => 1,
                    ]);

                    $operatingHours = [];
                    for ($day = 0; $day <= 6; $day++) {
                        $operatingHours[] = [
                            'day_of_week' => $day,
                            'open_time' => '07:00:00',
                            'close_time' => '22:00:00',
                            'is_open' => true,
                        ];
                    }
                    $field->operatingHours()->createMany($operatingHours);

                    $pricings = [
                        ['day_type' => 'weekday', 'price_per_slot' => rand(10, 15) * 10000],
                        ['day_type' => 'weekend', 'price_per_slot' => rand(15, 20) * 10000],
                        ['day_type' => 'holiday', 'price_per_slot' => rand(20, 25) * 10000],
                    ];
                    $field->pricings()->createMany($pricings);
                });
        }

        $this->command->info('Seeding Lapangan, Jam Operasional, dan Harga selesai dengan mantap!');
    }
}
