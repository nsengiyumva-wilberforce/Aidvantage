<?php
namespace App\Http\Controllers;

use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Models\Sale; // Import the Sale model

class SaleController extends Controller
{
    public function index()
    {
        // Get all the sales for the authenticated user
        $sales = Sale::where('user_id', auth()->user()->id)->get();

        // Return a collection of sales
        return response()->json(['data' => $sales], 200);
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'business_id' => 'required|exists:mappings,id',
        ]);

        $sale = new Sale();
        $sale->business_id = $request->input('business_id');
        $sale->user_id = auth()->user()->id;
        
        $sale->save();

        $sale_products = $request->input('sale_products');

        if (!empty($sale_products)) {
            foreach ($sale_products as $sale_product) {
                $product = new SaleProduct();

                $product->sale_id = $sale->id;
                $product->product_id = $sale_product['product_id'];
                $product->quantity = $sale_product['quantity'];

                $product->save();
            }
        }

        return response()->json(['data' => $sale, 'message' => 'Sale created successfully'], 201);
    }
}
