<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'action',
        'details',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    static function statuses(){
        return [
            'Returned to Stock',
            'Return to supplier',
            'Taken from Stock',
            'Stock Transfer',
            'Entry to Stock',
            'Borrowed Returnable',
            'Returned Returnable',
        ];
    }

}
