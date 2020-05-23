<?php

namespace App\Http\Controllers\Front;

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
        $data = Restaurant::where('id', $id)->with('menu', 'menu.options')->first();
        /*echo "<pre>";
        print_r($data);die;*/

       return view('pages.restaurant.show', compact('data'));
	}
}
