<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VenueSportCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_field_sport_categories_returns_all_categories_from_fields(): void
    {
        $futsal = SportsCategory::create(['name' => 'Futsal', 'slug' => 'futsal', 'is_active' => true]);
        $badminton = SportsCategory::create(['name' => 'Badminton', 'slug' => 'badminton', 'is_active' => true]);
        $tenis = SportsCategory::create(['name' => 'Tenis', 'slug' => 'tenis', 'is_active' => true]);

        $venue = Venue::factory()->create();
        $venue->sportsCategories()->attach($futsal->id);

        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $futsal->id,
        ]);
        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $badminton->id,
        ]);
        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $tenis->id,
        ]);

        $categories = $venue->fieldSportCategories()->pluck('name')->all();

        $this->assertEqualsCanonicalizing(
            ['Badminton', 'Futsal', 'Tenis'],
            $categories
        );
    }

    public function test_sync_sport_categories_from_fields_updates_pivot_table(): void
    {
        $futsal = SportsCategory::create(['name' => 'Futsal', 'slug' => 'futsal', 'is_active' => true]);
        $badminton = SportsCategory::create(['name' => 'Badminton', 'slug' => 'badminton', 'is_active' => true]);

        $venue = Venue::factory()->create();
        $venue->sportsCategories()->attach($futsal->id);

        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $futsal->id,
        ]);
        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $badminton->id,
        ]);

        $venue->syncSportCategoriesFromFields();

        $this->assertEqualsCanonicalizing(
            [$futsal->id, $badminton->id],
            $venue->sportsCategories()->pluck('sports_categories.id')->all()
        );
    }

    public function test_venue_show_page_displays_all_field_sport_categories(): void
    {
        $futsal = SportsCategory::create(['name' => 'Futsal', 'slug' => 'futsal', 'is_active' => true]);
        $badminton = SportsCategory::create(['name' => 'Badminton', 'slug' => 'badminton', 'is_active' => true]);

        $venue = Venue::factory()->create();
        $venue->sportsCategories()->attach($futsal->id);

        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $futsal->id,
        ]);
        Field::factory()->create([
            'venue_id' => $venue->id,
            'sports_category_id' => $badminton->id,
        ]);

        $response = $this->get(route('venues.show', $venue->slug));

        $response->assertOk();
        $response->assertSee('Futsal');
        $response->assertSee('Badminton');
    }
}
