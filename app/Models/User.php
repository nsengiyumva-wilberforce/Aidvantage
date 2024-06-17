<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function demos()
    {
        return $this->hasMany(Demo::class);
    }

    //sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    //appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    //deliveries
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    //a user can have many targets
    public function targets()
    {
        return $this->hasMany(Target::class);
    }

    //user can have 
}
