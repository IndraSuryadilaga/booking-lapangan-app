<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use App\Services\VenueFilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class VenueFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_venue_index_filters_by_search_city_and_category(): void
    {
        $futsal = SportsCategory::create(['name' => 'Futsal', 'slug' => 'futsal', 'is_active' => true]);
        $badminton = SportsCategory::create(['name' => 'Badminton', 'slug' => 'badminton', 'is_active' => true]);

        $venueA = Venue::factory()->create(['name' => 'Arena Futsal Banjar', 'city' => 'Banjarmasin']);
        $venueB = Venue::factory()->create(['name' => 'Gelora Badminton', 'city' => 'Banjarbaru']);

        Field::factory()->create(['venue_id' => $venueA->id, 'sports_category_id' => $futsal->id]);
        Field::factory()->create(['venue_id' => $venueB->id, 'sports_category_id' => $badminton->id]);

        $service = app(VenueFilterService::class);

        $byCity = $service->filterVenues(Request::create('/venues', 'GET', ['city' => 'Banjarmasin']));
        $this->assertCount(1, $byCity);
        $this->assertTrue($byCity->first()->is($venueA));

        $bySearch = $service->filterVenues(Request::create('/venues', 'GET', ['search' => 'Badminton']));
        $this->assertCount(1, $bySearch);
        $this->assertTrue($bySearch->first()->is($venueB));

        $byCategory = $service->filterVenues(Request::create('/venues', 'GET', ['category' => [$futsal->id]]));
        $this->assertCount(1, $byCategory);
        $this->assertTrue($byCategory->first()->is($venueA));
    }

    public function test_venue_index_page_renders_with_filter_options(): void
    {
        $category = SportsCategory::create(['name' => 'Tenis', 'slug' => 'tenis', 'is_active' => true]);
        $venue = Venue::factory()->create(['city' => 'Jakarta']);
        Field::factory()->create(['venue_id' => $venue->id, 'sports_category_id' => $category->id]);

        $response = $this->get(route('venues.index', [
            'search' => $venue->name,
            'city' => 'Jakarta',
            'category' => [$category->id],
        ]));

        $response->assertOk();
        $response->assertSee($venue->name);
        $response->assertSee('Pilih Kategori', false);
        $response->assertSee('Pilih Kota', false);
    }
}
