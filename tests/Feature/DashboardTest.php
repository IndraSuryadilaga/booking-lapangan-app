<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
    }

    public function test_root_redirects_to_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_guest_is_redirected_to_login_when_visiting_booking_page(): void
    {
        $response = $this->get('/pesan');

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_can_view_booking_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pesan');

        $response->assertOk();
    }
}
