<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $maintenances], 200);
    }
}
