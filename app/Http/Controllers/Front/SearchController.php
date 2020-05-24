<?php

namespace App\Http\Controllers\Front;

use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;

class SearchController extends Controller{
    public function index(Request $request)
    {
        $query = $request->name;
        $results = Restaurant::where('name', 'LIKE', '%'.$query.'%')
                            ->orWhere('shortdescription', 'LIKE', '%'.$query.'%')
                            ->orWhere('description', 'LIKE', '%'.$query.'%')->get();

        return view('pages.restaurant.searchresult', compact('results'));
    }
}
