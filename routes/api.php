<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosnetController;

Route::post('/register-card', [PosnetController::class, 'registerCard']);
Route::post('/process-payment', [PosnetController::class, 'doPayment']);

Route::fallback(function () {
    return response()->json(['error' => 'Not Found!'], 404);
});
