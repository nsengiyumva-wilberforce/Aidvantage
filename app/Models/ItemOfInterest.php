<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOfInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'product_id',
        'quantity',
    ];
}
