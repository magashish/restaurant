<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;

class PropertyController extends Controller
{
    public function index(){
        //$restaurants = Restaurant::where('isfeatured', 1)->take(5)->get();
        return view('pages.property.properties');
        }
}
