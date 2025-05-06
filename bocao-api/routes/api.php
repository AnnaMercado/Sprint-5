<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{ AuthController,UserController, RestaurantController, CommentController};


Route::post('/tokens', [AuthController::class, 'login'])->name('tokens.create');
Route::post('/users', [UserController::class, 'create'])->name('users.create');

Route::middleware('auth:api')->group(function () {
    Route::delete('/tokens', [AuthController::class, 'logout'])->name('tokens.destroy');

    Route::get('/users', [UserController::class, 'read'])->name('users.read');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id?}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id?}', [UserController::class, 'delete'])->name('users.delete');

    Route::post('/restaurants', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::get('/restaurants', [RestaurantController::class, 'read'])->name('restaurants.read');
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');
    Route::put('/restaurants/{id?}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{id?}', [RestaurantController::class, 'delete'])->name('restaurants.delete');

    Route::post('/restaurants/{restaurant}/comments', [CommentController::class, 'create'])->name('comments.create');
});