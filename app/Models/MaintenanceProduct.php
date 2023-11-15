<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'product_id',
        'quantity',
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
