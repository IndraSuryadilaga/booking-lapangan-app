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
        // View Composer khusus untuk Sidebar
        View::composer('components.organisms.quick-access-sidebar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Ambil booking pending (Keranjang)
                $pendingBookings = Booking::with('field.venue')
                    ->where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->latest()
                    ->get();

                // Ambil tiket aktif (Belum lewat tanggal mainnya)
                $activeBookings = Booking::with('field.venue')
                    ->where('user_id', $user->id)
                    ->whereIn('status', ['paid', 'confirmed'])
                    ->whereDate('booking_date', '>=', now()->toDateString())
                    ->latest()
                    ->get();

                $view->with(compact('pendingBookings', 'activeBookings'));
            } else {
                $view->with(['pendingBookings' => collect(), 'activeBookings' => collect()]);
            }
        });
    }
}
