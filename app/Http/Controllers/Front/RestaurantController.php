<?php

namespace App\Http\Controllers\Front;

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
        $requestFields = $request->all();
        if (isset($requestFields['cat'])) {
            $data = Restaurant::where(['id' => $id])->whereRaw("categories REGEXP '[[:<:]]".$requestFields['cat']."[[:>:]]'")->with('menu', 'menu.options')->first();
        } else {
            $data = Restaurant::where('id', $id)->with('menu', 'menu.options')->first();
        }

        $catData = [];
        if (isset($requestFields['cat'])) {
        $data->categories ?? "";
        $cat = json_decode($data->categories ?? "[]");
		if(!empty($cat)) {
        $catData = Category::find($cat)->pluck('name','id');
		 }
        }
       return view('pages.restaurant.show', compact('data', 'catData'));
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
