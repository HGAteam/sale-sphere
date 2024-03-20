<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'address',
        'status',
        'branch_manager',
        'phone',
        'mobile',
        'cashiers',
        'details',
        'deleted_at'
    ];

    public function products(){
       return $this->hasMany(Product::class);
    }
    public function stocks(){
        return $this->hasMany(Stock::class, 'warehouse_id', 'id');
    }
}
