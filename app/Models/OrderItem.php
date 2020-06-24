<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function item_detail()
    {
        return $this->belongsTo(RestaurantMenu::class, 'restaurant_menu_id');
    }
}
