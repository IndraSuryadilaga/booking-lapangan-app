<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VenueLogoDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_venue_logo()
    {
        Storage::fake('public');
        
        $user = User::factory()->create(['role' => 'super-admin']);
        
        $logoFile = UploadedFile::fake()->image('logo.jpg');
        $logoPath = $logoFile->store('venues', 'public');

        $venue = Venue::create([
            'admin_id' => $user->id,
            'name' => 'Test Venue',
            'slug' => 'test-venue',
            'address' => 'Test Address',
            'city' => 'Test City',
            'province' => 'Test Province',
            'logo' => $logoPath,
        ]);

        Storage::disk('public')->assertExists($logoPath);

        $response = $this->actingAs($user)->delete(route('admin.venues.delete-logo', $venue->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Logo venue berhasil dihapus.');

        Storage::disk('public')->assertMissing($logoPath);
        $this->assertNull($venue->fresh()->logo);
    }
}
