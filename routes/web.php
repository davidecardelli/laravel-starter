<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * Home route - Redirect to dashboard or login
 */
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

/**
 * Dashboard - Protected route for authenticated users
 */
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * User Management - Admin only
 */
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::post('users/{user}/roles/{role}', [UserController::class, 'assignRole'])
        ->name('users.assign-role');
    Route::delete('users/{user}/roles/{role}', [UserController::class, 'removeRole'])
        ->name('users.remove-role');
});

require __DIR__.'/settings.php';
