<?php

use App\Http\Controllers\ProductController;
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

