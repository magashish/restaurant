<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name', 'logo', 'timings','isopen','shortdescription','description'
    ];

    public function menu()
    {
        return $this->hasMany('App\Models\RestaurantMenu', 'restaurant_id');
    }

    public function getLogoAttribute($value = "")
    {
        if(!empty($value)) {
            return asset("uploads/$value");
        }
        return $value;
    }
}
