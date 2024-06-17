<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetMetric extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'target_value', 'actual_value', 'deadline'];
}
