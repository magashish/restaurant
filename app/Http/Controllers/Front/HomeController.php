<?php

namespace App\Http\Controllers\Front;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use Log;

class HomeController extends Controller
{
    public function index(){
    $restaurants = Restaurant::where('isfeatured', 1)->take(5)->get();
    return view('pages.home',compact('restaurants'));
    }
}
