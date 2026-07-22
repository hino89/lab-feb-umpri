<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/lab/{id}', [PublicController::class, 'show'])->name('lab.show');
Route::post('/lab/{id}/book', [PublicController::class, 'storeBooking'])->name('lab.book');

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaboratoryController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\HeroSettingController;

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Admin Protected Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings
    Route::get('/settings/hero', [HeroSettingController::class, 'index'])->name('settings.hero');
    Route::post('/settings/hero', [HeroSettingController::class, 'update'])->name('settings.hero.update');

    // CRUD Laboratories
    Route::resource('laboratories', LaboratoryController::class);
    Route::delete('laboratories/images/{image}', [LaboratoryController::class, 'destroyImage'])->name('laboratories.images.destroy');
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::resource('users', UserController::class);
});
