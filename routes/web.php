<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminSportsCategoryController;
use App\Http\Controllers\Admin\AdminFieldController;
use App\Http\Controllers\Admin\AdminFacilityController;
use App\Http\Controllers\Admin\AdminPublicHolidayController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/pesan', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'isAdminOrSuperAdmin', 'isSuperAdmin'])
    ->prefix('admin')
    ->group(function () {

    Route::resource('categories', AdminSportsCategoryController::class);

    Route::resource('facilities', AdminFacilityController::class);

    Route::resource('holidays', AdminPublicHolidayController::class);
});

Route::middleware(['auth', 'isAdminOrSuperAdmin'])->prefix('admin')->group(function () {

    Route::resource('sports-categories', AdminSportsCategoryController::class);

    Route::resource('fields', AdminFieldController::class);

    Route::get('/field-images/{image}/primary', [AdminFieldController::class, 'setPrimaryImage'])
        ->name('fields.images.primary');

    Route::get('/field-images/{image}/delete', [AdminFieldController::class, 'deleteImage'])
        ->name('fields.images.delete');
});

Route::get('/admin/test', function () {
    return 'Halo Admin! Anda berhasil masuk ke benteng pertahanan.';
})->middleware('isAdminOrSuperAdmin');

Route::get('/styleguide', function () {
    return view('styleguide');
});

require __DIR__.'/auth.php';