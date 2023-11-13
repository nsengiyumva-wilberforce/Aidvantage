<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'message'=> 'products retrieved successfully',
            'data' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'product_name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        if (!$product) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json(['data' => $product, 'message' => 'Product created successfully'], 201);
    }
}
