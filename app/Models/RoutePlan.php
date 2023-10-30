<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'route_description',
        'start_location',
        'end_location',
        'route_start_date',
        'route_end_date',
        'user_id',
    ];
}
