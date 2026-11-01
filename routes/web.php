<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard berdasarkan role
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'pelapor' => redirect()->route('dashboard.pelapor'),
            'pemantau' => redirect()->route('dashboard.pemantau'),
            'koordinator' => redirect()->route('dashboard.koordinator'),
            default => abort(403),
        };
    })->name('dashboard');

    Route::middleware('role:pelapor')->group(function () {
        Route::view('/dashboard/pelapor', 'dashboard.pelapor')
            ->name('dashboard.pelapor');
    });

    Route::middleware('role:pemantau')->group(function () {
        Route::view('/dashboard/pemantau', 'dashboard.pemantau')
            ->name('dashboard.pemantau');
    });

    Route::middleware('role:koordinator')->group(function () {
        Route::view('/dashboard/koordinator', 'dashboard.koordinator')
            ->name('dashboard.koordinator');
    });
});
