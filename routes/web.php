<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChambreController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('reservations.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('chambres', ChambreController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{reservation}/pay', [PaymentController::class, 'store'])->name('payments.store');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('chambres', ChambreController::class);
        Route::resource('reservations', ReservationController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::post('/reservations/{reservation}/pay', [PaymentController::class, 'store'])->name('payments.store');
});

require __DIR__.'/auth.php';
