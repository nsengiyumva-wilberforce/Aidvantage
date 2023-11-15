<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visit_id'
    ];

    public function visit()
    {
        return $this->belongsTo('App\Models\Visit', 'visit_id');
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
