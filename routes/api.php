<?php

declare(strict_types=1);

use App\Http\Controllers\PosnetController;
use Illuminate\Support\Facades\Route;

Route::post('/register-card', [PosnetController::class, 'registerCard']);
Route::post('/process-payment', [PosnetController::class, 'doPayment']);

Route::fallback(function () {
    return response()->json(['error' => 'Not Found!'], 404);
});
