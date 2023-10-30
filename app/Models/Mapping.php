<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'business_telephone_contact',
        'business_email_contact',
        'business_product_of_interest',
        'business_location',
        'physical_address',
        'contact_person_name',
        'contact_person_telephone',
        'contact_person_email',
        'contact_person_gender',
        'pitch_interest',
        'notes',
        'user_id',
    ];
}
