<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'user_id',
        'name',
        'status',
        'balance',
        'opening_balance',
        'closing_balance',
        'opening_details',
        'closing_details'
    ];
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authorizations()
    {
        return $this->hasMany(CashRegisterAuthorization::class);
    }
}
