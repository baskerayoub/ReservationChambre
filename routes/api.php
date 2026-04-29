<?php

use App\Http\Controllers\Api\V1\ChambreController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/chambres', [ChambreController::class, 'index'])->name('chambres.index');
    Route::get('/chambres/{chambre}', [ChambreController::class, 'show'])->name('chambres.show');
    Route::get('/availability', [ChambreController::class, 'availability'])->name('availability');
});
