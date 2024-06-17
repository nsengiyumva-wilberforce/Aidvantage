<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetMetric;

class TargetMetricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targetMetrics = TargetMetric::all();

        return response()->json([
            'message' => 'Successfully retrieved all target metrics',
            'data' => $targetMetrics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $targetMetric = TargetMetric::create($request->all());

            return response()->json([
                'message' => 'Successfully created target metric',
                'data' => $targetMetric
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create target metric',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
