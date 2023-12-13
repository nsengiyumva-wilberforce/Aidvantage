<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
            'description' => $request->description,
            'unit' => $request->unit,
            "type"=> $request->type,
        ]);

        if (!$product) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json(['data' => $product, 'message' => 'Product created successfully'], 201);
    }

    //update product
    public function update(Request $request, Product $product)
    {
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
            'description' => $request->description,
            'unit' => $request->unit,
            "type"=> $request->type,
        ]);

        return response()->json(['data' => $product, 'message' => 'Product updated successfully'], 200);
    }

    //delete product
    public function delete(Product $product)
    {
        try {
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            // Check if the error code corresponds to a foreign key constraint violation
            if ($errorCode == 1451) {
                return response()->json(['error' => 'Cannot delete the product because it is being referenced by other records.'], 400);
            }

            // If it's a different type of error, you can handle it accordingly
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
    public function updateQuantity(Request $request, Product $product)
    {
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

     //get the current quantity and add the new quantity
        $currentQuantity = $product->quantity;
        $newQuantity = $currentQuantity + $request->quantity;

        //update the quantity
        $product->update([
            'quantity' => $newQuantity,
        ]);

        return response()->json(['data' => $product, 'message' => 'Product quantity updated successfully'], 200);
    }

    //get coffee machines
    public function getCoffeeMachines()
    {
        $coffeeMachines = Product::where('type', 'coffee_machine')->get();

        return response()->json([
            'message'=> 'coffee machines retrieved successfully',
            'data' => $coffeeMachines
        ], 200);
    }

    //get coffee pods
    public function getCoffeeProducts()
    {
        $coffeePods = Product::where('type', 'coffee_product')->get();

        return response()->json([
            'message'=> 'coffee pods retrieved successfully',
            'data' => $coffeePods
        ], 200);
    }
}
