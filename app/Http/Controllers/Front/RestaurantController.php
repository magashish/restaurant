<?php

namespace App\Http\Controllers\Front;

use App\RestaurantCategory;
use DB;
use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function show(Request $request, $id)
    {
        // dd('in');
        $requestFields = $request->all();
        $category = '';
        if (isset($requestFields['cat'])) {
            // dd('in');
            $category = $requestFields['cat'];
            //$data = Restaurant::where(['id' => $id])->orWhereRaw("categories REGEXP '[[:<:]]" . $requestFields['cat'] . "[[:>:]]'")->with('menu', 'menu.options')->first();
            $data = Restaurant::where(['id' => $id])
                ->whereHas('menu', function ($q) use($category) {
                    $q->where('category_id', $category);
                })
                ->with('menu', 'menu.options')->first();
        } else {
            // dd('out');
            $data = Restaurant::where('id', $id)->with('menu', 'menu.options')->first();
            // dd($data);
        }
        $restaurantData = Restaurant::where('id', $id)->first();

        $catData = RestaurantCategory::where('restaurant_id', $id)->with('category_detail')->get();

        $restaurantId = $id;
        // dd($catData);
        return view('pages.restaurant.show', compact('data', 'catData', 'restaurantId', 'restaurantData', 'category'));
    }

    public function allrestaurant()
    {
        $restaurants = Restaurant::latest()->get();
        return view('pages.restaurant.allrestaurants', compact('restaurants'));
    }

    public function allRestaurantList()
    {
        $restaurants = Restaurant::latest()->get();
        return view('pages.restaurant', compact('restaurants'));
    }
}
