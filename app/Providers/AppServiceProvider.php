<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
