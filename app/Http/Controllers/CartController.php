<?php

namespace App\Http\Controllers;

use App\Models\RestaurantMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;

class CartController extends Controller{
    public function addtocart(Request $request)
    {

       $prodId = $request->post('pid');
       $data = RestaurantMenu::find($prodId, ['restaurant_id', 'image']);
       if(!$data) {
        abort(404);
       }
       $proddata = $request->all();
       $cart = session()->get('cart');

       // if cart is empty then this the first product
       if(!$cart) {
        $cart = [
                $prodId => [
                    "name" =>$request->post('pname'),
                    "quantity" => $request->post('pqty'),
                    "price" =>  $request->post('price'),
                    "photo" =>  $data->image
                ]
            ];
        session()->put('cart', $cart);
       //return redirect()->back()->with('success', 'Product added to cart successfully!');
       return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
      }
      // if cart not empty then check if this product exist then increment quantity
      if(isset($cart[$prodId])) {
        $cart[$prodId]['quantity']++;
        session()->put('cart', $cart);
        return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
      }
      // if item not exist in cart then add to cart with quantity = 1
      $cart[$prodId] = [
        "name" => $request->post('pname'),
        "quantity" => $request->post('pqty'),
        "price" => $request->post('price'),
        "photo" =>  $data->image
      ];
      session()->put('cart', $cart);
      return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
    }
}
