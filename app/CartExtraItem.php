<?php

namespace App;

use App\Models\RestaurantMenuOption;
use Illuminate\Database\Eloquent\Model;

class CartExtraItem extends Model
{
    public function menu_option_detail()
    {
        return $this->belongsTo(RestaurantMenuOption::class, 'restaurant_menu_option_id');
    }
}
