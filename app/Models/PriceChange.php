<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'old_purchase_price',
        'new_purchase_price',
        'old_selling_price',
        'new_selling_price',
        'old_wholesale_price',
        'new_wholesale_price',
        'details',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
