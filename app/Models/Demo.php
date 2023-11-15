<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    use HasFactory;

    public function visit()
    {
        return $this->belongsTo('App\Models\Visit', 'visit_id');
    }
}
