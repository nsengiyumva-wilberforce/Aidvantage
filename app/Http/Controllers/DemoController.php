<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index()
    {
        // Get all the demos for the authenticated user
        $demos = Demo::where('user_id', auth()->user()->id)->get();

        // Return a collection of demos
        return response()->json(['data' => $demos], 200);
    }
}
