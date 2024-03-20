<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'slug',
        'email',
        'status',
        'dni',
        'image',
        'address',
        'location',
        'phone',
        'mobile',
        'details',
        'deleted_at'
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('/images/blank.png');
        }
        return asset($value);
    }
}
