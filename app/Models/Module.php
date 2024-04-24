<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id',
        'title',
        'details',
        'image',
        'benefits',
        'features',
        'price',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
    ];

    public function setting(){
        return $this->hasMany(Setting::class);
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('images/apps/default.jpg');
        }
        return asset($value);
    }
}
