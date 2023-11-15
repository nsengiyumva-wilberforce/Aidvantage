<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Retrieve maintenances with user, visit, business, and product information
        $maintenances = $user->maintenances()
            ->with(['visit' => function ($query) {
                $query->select('id', 'business_id'); // Assuming 'business_id' is the foreign key in the 'visits' table
            }])
            ->with(['visit.visit' => function ($query) {
                $query->select('id', 'business_name'); // Assuming 'business_name' is the column in the 'mappings' table
            }])
            ->with(['maintenanceProducts.product' => function ($query) {
                $query->select('id', 'product_name'); // Assuming 'product_name' is the column in the 'products' table
            }])
            ->get();

        return response()->json([
            'message' => 'Successfully fetched all maintenances',
            'data' => $maintenances
        ], 200);
    }
}
