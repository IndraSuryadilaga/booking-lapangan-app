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
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// hlm utama & statis
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/styleguide', fn() => view('pages.styleguide'));
Route::get('/partner', fn() => view('pages.partner'))->name('partner');

// lapangan & venue (publik)
Route::get('/fields/{field:slug}', [FieldController::class, 'show'])->name('fields.show');
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/{venue:slug}', [VenueController::class, 'show'])->name('venues.show');

// rute autentikasi (login, register, dll)
Route::middleware('auth')->group(function () {

    // dashboard umum user & admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // manajemen profil user
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'show')->name('profile.show');
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::get('/profile/delete', 'deleteConfirm')->name('profile.delete');
        Route::match(['put', 'patch'], '/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // khusus customer (admin dilarang masuk)
    Route::middleware('forbidAdmin')->group(function () {

        // transaksi & riwayat booking
        Route::prefix('bookings')->name('bookings.')->controller(BookingController::class)->group(function () {
            Route::post('/init', 'init')->name('init');
            Route::get('/confirm', 'confirm')->name('confirm');
            Route::post('/store', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/history', 'history')->name('history');
            Route::get('/{booking}', 'show')->name('show');
            Route::patch('/{booking}/cancel', 'cancel')->name('cancel');
        });

        // proses pembayaran midtrans/manual
        Route::prefix('payments')->name('payments.')->controller(PaymentController::class)->group(function () {
            Route::get('/{booking}', 'show')->name('show');
            Route::post('/{booking}/process', 'process')->name('process');
        });

        // ulasan setelah selesai booking
        Route::prefix('bookings/{booking}/review')->name('reviews.')->controller(ReviewController::class)->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
    });
});

// area admin & super admin
Route::middleware(['auth', 'isAdminOrSuperAdmin'])->prefix('admin')->name('admin.')->group(function () {

    // dashboard admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // kelola lapangan & foto lapangan
    Route::patch('fields/{field}/toggle-status', [AdminFieldController::class, 'toggleStatus'])->name('fields.toggle-status');
    Route::resource('fields', AdminFieldController::class);
    Route::post('fields/{field}/images', [AdminFieldImageController::class, 'store'])->name('fields.images.store');
    Route::put('fields/{field}/images/{image}', [AdminFieldImageController::class, 'setPrimary'])->name('fields.images.primary');
    Route::delete('fields/images/{image}', [AdminFieldImageController::class, 'destroy'])->name('fields.images.destroy');

    // kelola data venue (oleh super admin / admin utama)
    Route::delete('venues/{venue}/logo', [AdminVenueController::class, 'deleteLogo'])->name('venues.delete-logo');
    Route::get('venues/{venue}/assign-admin', [AdminVenueController::class, 'assignAdmin'])->name('venues.assign-admin');
    Route::post('venues/{venue}/assign-admin', [AdminVenueController::class, 'storeAssignAdmin'])->name('venues.store-assign-admin');
    Route::resource('venues', AdminVenueController::class);

    // kelola profil venue milik admin yang sedang login
    Route::get('my-venue', [AdminVenueController::class, 'myVenue'])->name('venues.my-venue');
    Route::put('my-venue', [AdminVenueController::class, 'updateMyVenue'])->name('venues.my-venue.update');
    Route::delete('my-venue/logo', [AdminVenueController::class, 'deleteMyVenueLogo'])->name('venues.my-venue.delete-logo');

    // kelola/konfirmasi booking masuk
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

// area khusus super admin (master data)
Route::middleware(['auth', 'isSuperAdmin'])->prefix('admin')->group(function () {
    Route::resource('sports-categories', AdminSportsCategoryController::class)->parameters(['sports-categories' => 'sports_category']);
    Route::resource('facilities', AdminFacilityController::class);
    Route::resource('holidays', AdminPublicHolidayController::class);
});

// load file rute auth bawaan laravel breeze/jetstream
require __DIR__ . '/auth.php';
