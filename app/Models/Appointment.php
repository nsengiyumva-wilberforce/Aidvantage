<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function visit()
    {
        return $this->morphOne('App\Models\Visit', 'visitable', 'visit_purpose_type', 'visit_purpose_id');
    }
}
