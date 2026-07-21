<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/lab/{id}', [PublicController::class, 'show'])->name('lab.show');
Route::post('/lab/{id}/book', [PublicController::class, 'storeBooking'])->name('lab.book');
