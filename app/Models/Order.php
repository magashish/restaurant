<?php

namespace App\Models;
use App\User;
use App\OrderAddress;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function order_address()
    {
        return $this->belongsTo(OrderAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function restraunt()
    {
        return $this->belongsTo(Restaurant::class, 'restraunt_id');
    }
}
