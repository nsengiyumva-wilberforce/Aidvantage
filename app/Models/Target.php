<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_metrics_id',
    ];

    //a tatrget can belong to many users
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function targetMetrics()
    {
        return $this->belongsTo(TargetMetric::class, 'target_metrics_id');
    }
}
