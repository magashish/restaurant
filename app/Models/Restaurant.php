<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name', 'logo', 'timings','isopen','shortdescription','description','addr1','addr2','city','state','zipcode','country','phone','isfeatured'
    ];

    public function menu()
    {
        return $this->hasMany('App\Models\RestaurantMenu', 'restaurant_id');
    }

    public function getLogoAttribute($value = "")
    {
        if(!empty($value)) {
            return asset("uploads/logos/thumbnail/$value");
        }
        return $value;
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
