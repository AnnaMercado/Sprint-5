<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{ AuthController,};

Route::post('/tokens', [AuthController::class, 'login'])->name('tokens.create');

Route::middleware('auth:api')->group(function () {
    Route::delete('/tokens', [AuthController::class, 'logout'])->name('tokens.destroy');

    
});