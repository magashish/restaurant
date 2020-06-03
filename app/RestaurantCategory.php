<?php

namespace App;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    public function category_detail()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
