<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product_detail()
    {
        return $this->belongsTo(RestaurantMenu::class, 'restaurant_menu_id');
    }
}
