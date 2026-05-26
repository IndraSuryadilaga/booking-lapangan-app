<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminSportsCategoryController;
use App\Http\Controllers\Admin\AdminFieldController;

// Redirect root URL directly to the dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Main dashboard view for authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Booking creation page (Requires authentication)
Route::get('/pesan', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');

// User profile management routes (Requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes group (Requires both authentication and admin privileges)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // CRUD Operations for Sports Categories
    Route::resource('sports-categories', AdminSportsCategoryController::class);
    
    // CRUD Operations for Fields
    Route::resource('fields', AdminFieldController::class);

    // View the settings form for operating hours and pricing
    Route::get('/fields/{field}/settings', [AdminFieldController::class, 'settings'])->name('fields.settings');
    // Process the update for operating hours and pricing
    Route::patch('/fields/{field}/settings', [AdminFieldController::class, 'updateSettings'])->name('fields.settings.update');

    // Field Image Management (Set as primary & Delete)
    Route::patch('/field-images/{image}/primary', [AdminFieldController::class, 'setPrimaryImage'])->name('fields.images.primary');
    Route::delete('/field-images/{image}/delete', [AdminFieldController::class, 'deleteImage'])->name('fields.images.delete');
});

// Simple test route to verify Admin middleware functionality
Route::get('/admin/test', function () {
    return 'Halo Admin! Anda berhasil masuk ke benteng pertahanan.';
})->middleware('admin');

// UI Styleguide reference page
Route::get('/styleguide', function () {
    return view('styleguide');
});

// Include authentication routes (Login, Register, Password Reset, etc.)
require __DIR__.'/auth.php';