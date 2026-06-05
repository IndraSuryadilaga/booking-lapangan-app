<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\User;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\SportsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingMaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_create_booking_when_field_is_inactive_via_eloquent()
    {
        $user = User::factory()->create();
        
        $venue = Venue::create([
            'admin_id' => $user->id,
            'name' => 'Test Venue',
            'slug' => 'test-venue-' . uniqid(),
            'address' => 'Test Address',
            'city' => 'Test City',
            'province' => 'Test Province',
        ]);
        
        $category = SportsCategory::create([
            'name' => 'Test Sport',
            'slug' => 'test-sport-' . uniqid(),
        ]);
        
        $field = Field::create([
            'venue_id' => $venue->id,
            'sports_category_id' => $category->id,
            'name' => 'Test Field',
            'slug' => 'test-field-' . uniqid(),
            'type' => 'indoor',
            'is_active' => false,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Lapangan sedang ditutup sementara (Maintenance Mode).');

        Booking::create([
            'user_id' => $user->id,
            'field_id' => $field->id,
            'booking_date' => now()->addDay()->toDateString(),
            'total_slots' => 1,
            'total_price' => 100000,
            'status' => 'pending',
        ]);
    }

    public function test_cannot_access_field_detail_when_field_is_inactive()
    {
        $user = User::factory()->create();
        
        $venue = Venue::create([
            'admin_id' => $user->id,
            'name' => 'Test Venue',
            'slug' => 'test-venue-' . uniqid(),
            'address' => 'Test Address',
            'city' => 'Test City',
            'province' => 'Test Province',
        ]);
        
        $category = SportsCategory::create([
            'name' => 'Test Sport',
            'slug' => 'test-sport-' . uniqid(),
        ]);
        
        $field = Field::create([
            'venue_id' => $venue->id,
            'sports_category_id' => $category->id,
            'name' => 'Test Field',
            'slug' => 'test-field-' . uniqid(),
            'type' => 'indoor',
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)->get(route('fields.show', $field->slug));
        $response->assertStatus(404);
    }
}
