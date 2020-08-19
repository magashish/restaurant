<?php

namespace App;

use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const CUSTOMER = 'customer';
    const SELLER = 'seller';
    const RIDER = 'rider';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'stripe_customer_id', 'stripe_connect_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restaurant() {
        return $this->hasOne(Restaurant::class, 'seller_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }

   

}
