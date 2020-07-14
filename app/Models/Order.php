<?php

namespace App\Models;

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
}
