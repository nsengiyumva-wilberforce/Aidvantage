<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    public function visit()
    {
        return $this->belongsTo('App\Models\Visit', 'visit_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function maintenanceProducts()
    {
        return $this->hasMany(MaintenanceProduct::class);
    }
}
