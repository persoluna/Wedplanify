<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalApplication extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'business_name',
        'business_type',
        'location',
        'website_url',
        'instagram_handle',
        'additional_notes',
        'status',
    ];
}
