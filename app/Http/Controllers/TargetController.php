<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $targets], 200);
    }

    public function store(Request $request)
    {
        $target = Target::create([
            'user_id' => $request->user_id,
            'target_number_of_visits' => $request->target_number_of_visits,
            'target_start_date' => $request->target_start_date,
            'target_end_date' => $request->target_end_date,
        ]);

        if (!$target) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json(['data' => $target, 'message' => 'Target created successfully'], 201);
    }
}
