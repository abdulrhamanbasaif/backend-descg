<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Add this line

class ProductController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return a list of products
        return response()->json([
            'message' => 'List of products',
            'products' => [
                ['id' => 1, 'name' => 'Product 1', 'price' => 100],
                ['id' => 2, 'name' => 'Product 2', 'price' => 200],
            ]
        ]);
    }

    public function show($id)
    {
        // Logic to retrieve and return a single product by ID
        return response()->json([
            'message' => "Product with id $id",
            'product' => ['id' => $id, 'name' => "Product $id", 'price' => 100 * $id]
        ]);
    }

    public function store( Request $request)
    {
        // Logic to create a new product
         
        $product = [
            'id' => rand(3, 1000),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ];
        return response()->json([
            'message' => 'Product created',
            'product' => $product
        ], 201);

    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing product
        $product = [
            'id' => (int)$id,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ];
        return response()->json([
            'message' => 'Product updated',
            'product' => $product
        ]);

    }

    public function destroy($id)
    {
        // Logic to delete a product
        return response()->json([
            'message' => "Product with id $id deleted"
        ]);
    }
}
