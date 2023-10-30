<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $deliveries], 200);
    }
}
