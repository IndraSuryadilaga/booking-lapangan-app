<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFacilityController;
use App\Http\Controllers\Admin\AdminFieldController;
use App\Http\Controllers\Admin\AdminFieldImageController;
use App\Http\Controllers\Admin\AdminPublicHolidayController;
use App\Http\Controllers\Admin\AdminSportsCategoryController;
use App\Http\Controllers\Admin\AdminVenueController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Dashboard route handled by controller (requires authentication)

Route::get('/fields/{field:slug}', [FieldController::class, 'show'])->name('fields.show');

Route::middleware('auth')->group(function () {
    // Dashboard (user/admin) - shows personalized aggregates
    // Keep the route name `dashboard` but move path to `/dashboard`
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Booking Routes
    Route::prefix('bookings')->name('bookings.')->controller(BookingController::class)->group(function () {
        Route::get('/confirm', 'confirm')->name('confirm');
        Route::post('/', 'store')->name('store');
        Route::get('/', 'index')->name('index');
        Route::get('/history', 'history')->name('history');
        Route::get('/{booking}', 'show')->name('show');
        Route::patch('/{booking}/cancel', 'cancel')->name('cancel');
    });

// 1. Alur Booking & Konfirmasi
    Route::post('/booking/init', [\App\Http\Controllers\BookingController::class, 'init'])->name('bookings.init');
    Route::get('/booking/confirm', [\App\Http\Controllers\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/booking/store', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');

// 2. Alur Pembayaran
    Route::get('/payments/{booking}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{booking}/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payments.process');

// 3. Alur Riwayat (Untuk dikerjakan nanti)
    Route::get('/dashboard/riwayat', [\App\Http\Controllers\BookingController::class, 'history'])->name('bookings.history');
    Route::get('/dashboard/tiket/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');

    // Review Routes (authenticated, booking model-bound)
    Route::get('/bookings/{booking}/review/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/dashboard/riwayat', [\App\Http\Controllers\BookingController::class, 'history'])->name('bookings.history');
});
Route::get(
    '/venues',
    [VenueController::class, 'index']
)->name('venues.index');

Route::get(
    '/venues/{venue:slug}',
    [VenueController::class, 'show']
)->name('venues.show');

Route::middleware(['auth', 'isAdminOrSuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('fields', AdminFieldController::class);
    Route::patch('fields/{field}/toggle-status', [AdminFieldController::class, 'toggleStatus'])->name('fields.toggle-status');
    Route::resource('venues', AdminVenueController::class);
    Route::delete('venues/{venue}/logo', [AdminVenueController::class, 'deleteLogo'])->name('venues.delete-logo');
    Route::get('venues/{venue}/assign-admin', [AdminVenueController::class, 'assignAdmin'] )->name('venues.assign-admin');
    Route::post('venues/{venue}/assign-admin', [AdminVenueController::class, 'storeAssignAdmin'])->name('venues.store-assign-admin');
    Route::get('my-venue', [AdminVenueController::class, 'myVenue'])->name('venues.my-venue');
    Route::put('my-venue', [AdminVenueController::class, 'updateMyVenue'])->name('venues.my-venue.update');
    Route::delete('my-venue/logo', [AdminVenueController::class, 'deleteMyVenueLogo'])->name('venues.my-venue.delete-logo');
    Route::post('fields/{field}/images', [AdminFieldImageController::class, 'store'])->name('fields.images.store');
    Route::put('fields/{field}/images/{image}', [AdminFieldImageController::class, 'setPrimary'])->name('fields.images.primary');
    Route::delete('fields/images/{image}', [AdminFieldImageController::class, 'destroy'])->name('fields.images.destroy');

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

Route::middleware(['auth', 'isSuperAdmin'])
    ->prefix('admin')
    ->group(function () {
    Route::resource('sports-categories', AdminSportsCategoryController::class)->parameters(['sports-categories' => 'sports_category']);
    Route::resource('facilities', AdminFacilityController::class);
    Route::resource('holidays', AdminPublicHolidayController::class);
});

//testign routes
Route::get('/admin/test', function () {
    return 'Halo Admin! Anda berhasil masuk ke benteng pertahanan.';
})->middleware('isAdminOrSuperAdmin');

Route::get('/styleguide', function () {
    return view('pages.styleguide');
});

Route::get('/partner', function () {
    return view('pages.partner');
})->name('partner');

require __DIR__ . '/auth.php';

// Public home page (guest-facing)
Route::get('/', [HomeController::class, 'index'])->name('home');
