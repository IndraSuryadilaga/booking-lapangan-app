<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Field;
use App\Policies\BookingPolicy;
use App\Policies\FieldPolicy;
use App\Models\Venue;
use App\Policies\VenuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    Field::class => FieldPolicy::class,
    Venue::class => VenuePolicy::class,
];
        Field::class => FieldPolicy::class,
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
