<?php

namespace App\Http\Controllers\Front;

use App\RestaurantCategory;
use DB;
use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use App\Models\Category;
use App\Models\RestaurantMenuOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use App\CartExtraItem;
use App\Models\Cart;

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
        $category = '';
        $datas = [];
        $datas['data'] = [];
        if (isset($requestFields['cat'])) {
            $category = $requestFields['cat'];
            $data = Restaurant::where(['id' => $id])
                ->whereHas('menu', function ($q) use($category) {
                    $q->where('category_id', $category);
                })
                ->with('menu', 'menu.options')->first();
                if (\Auth::check()) {
                    $userId = \Auth::user()->id;
                    $datas['data'] = Cart::where('user_id', $userId)->with('product_detail', 'menu_options', 'menu_options.menu_option_detail')
                        ->get()->toArray();
                } else {
                    $cart = Session::get('cart');
                    $cartData = [];
                    if(!empty($cart)) {
                        foreach ($cart as $key => $data) {
                            $extraItemArr = [];
                            $data['extra_items'] = $data['extra_items'] ?? [];
                            foreach ($data['extra_items'] as $extraItemId) {
                                $extraItemArr[] = [
                                    "menu_option_detail" => RestaurantMenuOption::where('id', $extraItemId)->first()->toArray()
                                ];
                            }
                
                            $cartData[] = [
                                'id' => $key,
                                'user_id' => NULL,
                                'restaurant_menu_id' => $key,
                                'price' => $data['price'],
                                'quantity' => $data['quantity'],
                                'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray(),
                                'menu_options' => $extraItemArr,
                            ];
                        }
                        $datas['data'] = $cartData;
                    }
                }
        } else {
            if (\Auth::check()) {
                $userId = \Auth::user()->id;
                $datas['data'] = Cart::where('user_id', $userId)->with('product_detail', 'menu_options', 'menu_options.menu_option_detail')
                    ->get()->toArray();
            } else {
                $cart = Session::get('cart');
                $cartData = [];
                if(!empty($cart)) {
                    foreach ($cart as $key => $data) {
                        $extraItemArr = [];
                        $data['extra_items'] = $data['extra_items'] ?? [];
                        foreach ($data['extra_items'] as $extraItemId) {
                            $extraItemArr[] = [
                                "menu_option_detail" => RestaurantMenuOption::where('id', $extraItemId)->first()->toArray()
                            ];
                        }
            
                        $cartData[] = [
                            'id' => $key,
                            'user_id' => NULL,
                            'restaurant_menu_id' => $key,
                            'price' => $data['price'],
                            'quantity' => $data['quantity'],
                            'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray(),
                            'menu_options' => $extraItemArr,
                        ];
                    }
                    $datas['data'] = $cartData;
                }
            }
            $data = Restaurant::where('id', $id)->with('menu', 'menu.options')->first();
        }
       

        $restaurantData = Restaurant::where('id', $id)->first();
        $catData = RestaurantCategory::where('restaurant_id', $id)->with('category_detail')->get();
        $restaurantId = $id;
        return view('pages.restaurant.show', compact('data', 'datas', 'catData', 'restaurantId', 'restaurantData', 'category'));
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
