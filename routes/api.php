<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhookController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/products', [ProductController::class, 'index']); // Public

Route::middleware(['auth:sanctum', 'IsAdmin'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']); // Place order
    Route::get('/orders', [OrderController::class, 'userOrders']); // User's orders

    Route::middleware('IsAdmin')->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'adminOrders']); // Admin view
    });
});


Route::post('/webhooks/payment', [WebhookController::class, 'handlePayment']);
