<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Auth;
use Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $requestData = $request->all();
        $userData = User::where(['email' => $requestData['email']])->first();

        if ($userData && Hash::check($request->password, $userData->password)) {
            Auth::loginUsingId($userData->id);

            $cart = Session::get('cart');
            if (!empty($cart)) {
                foreach ($cart as $key => $data) {
                    $cartObj = new Cart;
                    $cartObj->user_id = \Auth::user()->id;
                    $cartObj->restaurant_menu_id = $key;
                    $cartObj->price = $data['price'];
                    $cartObj->quantity = $data['quantity'];
                    $cartObj->save();
                }
            }
            return redirect()->away($requestData['previous_url']);
            return redirect('/');
        } else {
            return redirect('login')->with('error', "Email and password do not match");
        }
    }
}
