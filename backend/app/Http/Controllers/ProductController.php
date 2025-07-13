<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request; // Add this line

class ProductController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return a list of products
        $products = Product::all();
        return $products;
    }

    public function show($id)
    {
        // Logic to retrieve and return a single product by ID
        $product = Product::find($id);
        return $product;
    }

    public function store( Request $request)
    {
        // Logic to create a new product
         
        $product = Product::create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'sku' => $request->input('sku'),
            'category' => $request->input('category'),
            'features' => $request->input('features'),
            'keywords' => $request->input('keywords'),
            'tone' => $request->input('tone'),
            'length' => $request->input('length'),
            'final_description' => $request->input('final_description'),
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);

    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing product
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->save();
        return $product;
    }

    public function destroy($id)
    {
        // Logic to delete a product
        $product= Product::find($id);
        $product->delete();
        return 'product deleted';
    }
}
