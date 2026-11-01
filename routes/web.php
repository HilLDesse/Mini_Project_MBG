<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportReviewController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportEvidenceController;
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

    // Akses bukti laporan
    Route::get('/reports/{id}/evidence', [
        ReportEvidenceController::class,
        'show'
    ])
        ->whereNumber('id')
        ->name('reports.evidence');

    // Dashboard berdasarkan role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'pelapor' => redirect()->route('dashboard.pelapor'),
            'pemantau' => redirect()->route('dashboard.pemantau'),
            'koordinator' => redirect()->route('dashboard.koordinator'),
            default => abort(403),
        };
    })->name('dashboard');

    // Role Pelapor
    Route::middleware('role:pelapor')->group(function () {

        Route::view('/dashboard/pelapor', 'dashboard.pelapor')
            ->name('dashboard.pelapor');

        // Fitur pelaporan
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/create', [ReportController::class, 'create'])
            ->name('reports.create');

        Route::get('/reports/distributions', [ReportController::class, 'distributionsBySchool'])
            ->name('reports.distributions');

        Route::post('/reports', [ReportController::class, 'store'])
            ->name('reports.store');

        Route::get('/reports/{id}', [ReportController::class, 'show'])
            ->whereNumber('id')
            ->name('reports.show');

        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])
            ->whereNumber('id')
            ->name('reports.edit');

        Route::put('/reports/{id}', [ReportController::class, 'update'])
            ->whereNumber('id')
            ->name('reports.update');
    });

    // Role Pemantau
    Route::middleware('role:pemantau')->group(function () {

        Route::view('/dashboard/pemantau', 'dashboard.pemantau')
            ->name('dashboard.pemantau');

        // Fitur pemeriksaan laporan
        Route::get('/reviews', [ReportReviewController::class, 'index'])
            ->name('reviews.index');

        Route::get('/reviews/{id}', [ReportReviewController::class, 'show'])
            ->whereNumber('id')
            ->name('reviews.show');

        Route::post('/reviews/{id}', [ReportReviewController::class, 'store'])
            ->whereNumber('id')
            ->name('reviews.store');
    });

    // Role Koordinator
    Route::middleware('role:koordinator')->group(function () {

        Route::get('/dashboard/koordinator', [DashboardController::class, 'coordinator'])
            ->name('dashboard.koordinator');

        // Fitur pencatatan tindak lanjut
        Route::get('/follow-ups', [FollowUpController::class, 'index'])
            ->name('follow-ups.index');

        Route::get('/follow-ups/{id}', [FollowUpController::class, 'show'])
            ->whereNumber('id')
            ->name('follow-ups.show');

        Route::post('/follow-ups/{id}', [FollowUpController::class, 'store'])
            ->whereNumber('id')
            ->name('follow-ups.store');
    });

});