<?php
namespace App\Http\Controllers;

use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;// Import the Sale model

class SaleController extends Controller

{
    public function index()
    {
         // Get the logged-in user
    $user = Auth::user();

    // Retrieve maintenances with user, visit, and business information
    $sales = $user->sales()
    ->with(['visit' => function ($query) {
        $query->select('id', 'business_id'); // Assuming 'business_id' is the foreign key in the 'visits' table
    }])
    ->with(['visit.visit' => function ($query) {
        $query->select('id', 'business_name'); // Assuming 'business_name' is the column in the 'mappings' table
    }])
    ->with(['saleProducts.product' => function ($query) {
        $query->select('id', 'product_name'); // Assuming 'product_name' is the column in the 'products' table
    }])
    ->get();

        return response()->json(
            [
                'message' => 'successfully fetched all maintenances',
                'data' => $sales
                ]
            , 200);
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
