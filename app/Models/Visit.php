<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'visit_purpose',
        'visit_notes',
        'user_id',
    ];

    public function maintenance()
    {
        return $this->hasOne('App\Models\Maintenance', 'visit_id');
    }

    public function demo()
    {
        return $this->hasOne('App\Models\Demo', 'visit_id');
    }

    public function visit()
    {
        return $this->belongsTo(Mapping::class, 'business_id');
    }

}
