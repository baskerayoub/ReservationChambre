<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect
    Route::get('/dashboard', function () {
        return auth()->user()->isStaff()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('reservations.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reservations
    Route::resource('reservations', ReservationController::class);

    // Payments
    Route::post('/reservations/{reservation}/pay/stripe', [PaymentController::class, 'stripeCheckout'])->name('payment.stripe');
    Route::get('/reservations/{reservation}/pay/stripe/success', [PaymentController::class, 'stripeSuccess'])->name('payment.success');
    Route::post('/reservations/{reservation}/pay/paypal', [PaymentController::class, 'paypalCheckout'])->name('payment.paypal');
    Route::get('/reservations/{reservation}/pay/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('payment.paypal.success');
    Route::get('/reservations/{reservation}/pay/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Reviews
    Route::post('/reservations/{reservation}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // AI Chatbot
    Route::post('/chatbot', [ChatbotController::class, 'send'])->name('chatbot.send')->middleware('throttle:30,1');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin,receptionist'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Room management
        Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms');
        Route::get('/rooms/create', [AdminController::class, 'createRoom'])->name('rooms.create');
        Route::post('/rooms', [AdminController::class, 'storeRoom'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('rooms.edit');
        Route::put('/rooms/{room}', [AdminController::class, 'updateRoom'])->name('rooms.update');
        Route::delete('/rooms/{room}', [AdminController::class, 'destroyRoom'])->name('rooms.destroy');

        // Reservation management
        Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
        Route::patch('/reservations/{reservation}/status', [AdminController::class, 'updateReservationStatus'])->name('reservations.status');

        // User management (admin only)
        Route::middleware('role:admin')->group(function () {
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
        });

        // Payment management
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');

        // Review management
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::patch('/reviews/{review}/toggle', [AdminController::class, 'toggleReviewApproval'])->name('reviews.toggle');
    });

require __DIR__ . '/auth.php';
