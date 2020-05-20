<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;

class RestaurantController extends Controller{
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
    public function show($id)
    {
        $maindata = Restaurant::find($id);
        /*$data = DB::table('restaurants')
				->join('restaurant_menu', function($join) use ($id)
				{
					$join->on('restaurants.id', '=', 'restaurant_menu.restaurant_id')
						    ->where('restaurant_menu.restaurant_id', '=', $id);
				})
				->get();*/
        $data = Restaurant::where('id', $id)->with('menu')->first();
        /*echo "<pre>";
        print_r($data);die;*/

       return view('pages.restaurant.show', compact('maindata','data'));
	}
}
