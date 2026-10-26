<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/restaurants/{restaurant:slug}', [RestaurantController::class, 'show'])->name('restaurants');
    
    Route::get('/carts', [CartController::class, 'index'])->name('carts');
    Route::post('/carts/items', [CartController::class, 'store'])->name('addToCart');
    Route::patch('/carts/items/{cartItem}', [CartController::class, 'update'])->name('cartItems.update');
    Route::delete('/carts/items/{cartItem}', [CartController::class, 'destroy'])->name('cartItems.destroy');
    });

require __DIR__.'/auth.php';
