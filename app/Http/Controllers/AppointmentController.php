<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $appointments], 200);
    }
}
