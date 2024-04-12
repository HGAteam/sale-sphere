<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'slug',
        'avatar',
        'role',
        'status',
        'phone',
        'mobile',
        'address',
        'location',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     public function cashRegisterAuthorizations()
    {
        return $this->hasMany(CashRegisterAuthorization::class);
    }

    public function authorizedCashRegisters()
    {
        return $this->belongsToMany(CashRegister::class, 'cash_register_authorizations');
    }

    static function roles (){
        $arrayName = array([
            'Admin', 'Owner', 'Cashier', 'Supplier', 'Client'
        ]);
        return $arrayName;
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            return asset('images/blank.png');
        }
        return asset($value);
    }
}
