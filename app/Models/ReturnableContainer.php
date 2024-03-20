<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnableContainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'product_id',
        'quantity_available',
        'quantity_borrowed',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    static function statuses(){
       return ['Borrowed','Returned','Presented'];
    }
}
