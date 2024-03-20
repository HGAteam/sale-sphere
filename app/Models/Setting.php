<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'owner_name',
        'email',
        'cuit',
        'logo',
        'central_location',
        'location_code',
        'phone',
        'mobile'
    ];
}
