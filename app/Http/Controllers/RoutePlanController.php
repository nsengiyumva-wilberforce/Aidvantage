<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoutePlan; // Import the RoutePlan model

class RoutePlanController extends Controller
{
    public function index()
    {
        $routePlans = RoutePlan::where('user_id', auth()->user()->id)->get();

        return response()->json(
            [
                'message' => 'Route plans retrieved successfully',
                'data' => $routePlans
            ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_name' => 'required|string',
            'route_description' => 'required|string',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'route_start_date' => 'required|string',
            'route_end_date' => 'required|string',
        ]);

        $routePlan = new RoutePlan();
        $routePlan->route_name = $request->input('route_name');
        $routePlan->route_description = $request->input('route_description');
        $routePlan->start_location = $request->input('start_location');
        $routePlan->end_location = $request->input('end_location');
        $routePlan->route_start_date = $request->input('route_start_date');
        $routePlan->route_end_date = $request->input('route_end_date');

        $routePlan->user_id = auth()->user()->id;

        if ($routePlan->save()) {
            return response()->json(['message' => 'Route plan created successfully'], 201);
        } else {
            return response()->json(['message' => 'Route plan failed to create'], 500);
        }
    }
}
