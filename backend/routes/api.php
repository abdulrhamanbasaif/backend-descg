<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//Should retrieve data from database
Route::get('/products', ProductController::class . '@index');

Route::get('/products/{id}', ProductController::class . '@show');

// Create new product
Route::post('/products', ProductController::class . '@store');


// Update product
Route::put('/products/{id}', ProductController::class . '@update');

// Delete product
Route::delete('/products/{id}', ProductController::class . '@destroy');

// user registration

Route::post('/register', UserController::class . '@register');

Route::post('/login', UserController::class . '@login');