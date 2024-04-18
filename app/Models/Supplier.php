<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_reason',
        'slug',
        'contact',
        'email',
        'cuit',
        'status',
        'image',
        'address',
        'location',
        'phone',
        'mobile',
        'deleted_at',
        'details'
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('images/suppliers/blank.png');
        }
        return asset($value);
    }
}
