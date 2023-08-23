<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', [Controllers\ListingController::class, 'index'])
    ->name('listings.index');

Route::get('/new', [Controllers\ListingController::class, 'create'])
    ->name('listings.create');

Route::post('/new', [Controllers\ListingController::class, 'store'])
    ->name('listings.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
