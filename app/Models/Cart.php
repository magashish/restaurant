<?php

namespace App\Models;

use App\CartExtraItem;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product_detail()
    {
        return $this->belongsTo(RestaurantMenu::class, 'restaurant_menu_id');
    }

    public function menu_options()
    {
        return $this->hasMany(CartExtraItem::class, 'cart_id');
    }
}
