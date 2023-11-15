<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    public function index()
    {
         // Get the logged-in user
    $user = Auth::user();

    // Retrieve maintenances with user, visit, and business information
    $demos = $user->demos()
        ->with(['visit' => function ($query) {
            $query->select('id', 'business_id'); // Assuming 'business_id' is the foreign key in the 'visits' table
        }])
        ->with(['visit.visit' => function ($query) {
            $query->select('id', 'business_name'); // Assuming 'business_name' is the column in the 'mappings' table
        }])
        ->get();

        return response()->json(
            [
                'message' => 'successfully fetched all demos',
                'data' => $demos

                ]
            , 200);
    }
}
