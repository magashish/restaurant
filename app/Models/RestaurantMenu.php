<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    protected $table = 'restaurant_menu';

    public function options()
    {
        return $this->hasMany('App\Models\RestaurantMenuOption', 'restaurant_menu_id');
    }
}
