<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'brand_id',
        'category_id',
        'barcode',
        'status',
        'description',
        'requires_returnable',
        'requires_stock',
        'purchase_price',
        'selling_price',
        'wholesale_price',
        'quantity',
        'unit',
    ];

    public function stock(){
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
