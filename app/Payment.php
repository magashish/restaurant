<?php

namespace App;

use App\Models\RestaurantMenu;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = ['customer_id', 'product_id', 'stripe_charge_id', 'paid_out', 'fees_collected', 'refunded'];

    protected $casts = ['refunded' => 'boolean'];

    public function customer() {
        return $this->hasOne(User::class, 'customer_id');
    }

    public function restaurant_menu() {
        return $this->hasMany(RestaurantMenu::class, 'restaurant_menu_id');
    }
}
