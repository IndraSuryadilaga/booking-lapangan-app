<?php

use App\Http\Controllers\Admin\AdminFacilityController;
use App\Http\Controllers\Admin\AdminFieldController;
use App\Http\Controllers\Admin\AdminFieldImageController;
use App\Http\Controllers\Admin\AdminPublicHolidayController;
use App\Http\Controllers\Admin\AdminSportsCategoryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/fields/{field:slug}', [FieldController::class, 'show'])->name('fields.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'isAdminOrSuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('fields', AdminFieldController::class);
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
    Route::resource('categories', AdminSportsCategoryController::class);
    Route::resource('facilities', AdminFacilityController::class);
    Route::resource('holidays', AdminPublicHolidayController::class);
});

//testign routes
Route::get('/admin/test', function () {
    return 'Halo Admin! Anda berhasil masuk ke benteng pertahanan.';
})->middleware('isAdminOrSuperAdmin');

Route::get('/styleguide', function () {
    return view('styleguide');
});

require __DIR__ . '/auth.php';
