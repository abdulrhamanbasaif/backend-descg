<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Should retrieve data from database
Route::get('/api/products', function () {
    return response()->json([
        'message' => 'List of products',
        'products' => [
            ['id' => 1, 'name' => 'Product 1', 'price' => 100],
            ['id' => 2, 'name' => 'Product 2', 'price' => 200],
        ]
    ]);
});
//Create new product
Route::post('/api/products', function () {
    // Only create product based on request body
});

