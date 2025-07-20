<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AiDescriptionLogController;
use App\Http\Controllers\SallaWebhookController;



// Auth Routes (Public)
Route::post('/register', [UserController::class, 'register']); // Register new user
Route::post('/login', [UserController::class, 'login']);       // Login user

// Protected Routes (Require Authentication)
//Route::middleware('auth:sanctum')->group(function () {
    // User Info Route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Product Routes (User-specific)
    Route::get('/products', [ProductController::class, 'index']);         // Get user's products
    Route::get('/products/{id}', [ProductController::class, 'show']);     // Get user's specific product
    Route::post('/products', [ProductController::class, 'store']);        // Create new product for user
    Route::put('/products/{id}', [ProductController::class, 'update']);   // Update user's product
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);// Delete user's product

    // AiDescriptionLog CRUD
    Route::get('/ai-description-logs', [AiDescriptionLogController::class, 'index']);
    Route::get('/ai-description-logs/{id}', [AiDescriptionLogController::class, 'show']);
    Route::post('/ai-description-logs', [AiDescriptionLogController::class, 'store']);
    Route::put('/ai-description-logs/{id}', [AiDescriptionLogController::class, 'update']);
    Route::delete('/ai-description-logs/{id}', [AiDescriptionLogController::class, 'destroy']);
    Route::post('/ai-description-logs/generate/{id}', [AiDescriptionLogController::class, 'generateDescription']);
//});
    Route::post('/salla/webhook', [SallaWebhookController::class, 'handle']);
