<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\RestaurantMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use Log;

class CartController extends Controller
{
    /*public function addtocart(Request $request)
    {

        $prodId = $request->post('pid');
        $data = RestaurantMenu::find($prodId, ['restaurant_id', 'image']);
        if (!$data) {
            abort(404);
        }
        $proddata = $request->all();
        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $prodId => [
                    "name" => $request->post('pname'),
                    "quantity" => $request->post('pqty'),
                    "price" => $request->post('price'),
                    "photo" => $data->image
                ]
            ];
            session()->put('cart', $cart);
            //return redirect()->back()->with('success', 'Product added to cart successfully!');
            return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
        }
        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$prodId])) {
            $cart[$prodId]['quantity']++;
            session()->put('cart', $cart);
            return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$prodId] = [
            "name" => $request->post('pname'),
            "quantity" => $request->post('pqty'),
            "price" => $request->post('price'),
            "photo" => $data->image
        ];
        session()->put('cart', $cart);
        return view('pages.cart.index')->with('success', 'Item added to Cart successfull');
    }*/

    public function cart(Request $request)
    {
        $data = [];
        $userId = \Auth::user()->id;
        $data['data'] = Cart::where('user_id', $userId)->with('product_detail')
            ->get()->toArray();

        //echo "<pre>";
        //print_r($data['data']);die;

        return view('pages.cart.index')->with(compact('data'));
    }

    public function updateCart(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        $requestFields = $request->all();

        try {
            $cardObj = Cart::find($requestFields['cart_id']);

            $cardObj->quantity = $requestFields['quantity'];
            if($cardObj->save()) {
                $response['success'] = TRUE;

                $userId = \Auth::user()->id;
                $cartData = Cart::where('user_id', $userId)->with('product_detail')
                    ->get()->toArray();

                $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();
            } else {
                $response['message'] = "Oops! some error occured, please try again";
            }
        } catch (\Exception $e) {
            $response = [
                'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
            ];
            $response['success'] = FALSE;
            Log::error($e->getTraceAsString());
        }
        return $response;
    }

    public function deleteCartItem(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        $requestFields = $request->all();

        try {
            if(Cart::where('id', $requestFields['cart_id'])->delete()) {
                $response['success'] = TRUE;

                $userId = \Auth::user()->id;
                $cartData = Cart::where('user_id', $userId)->with('product_detail')
                    ->get()->toArray();

                $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();
            } else {
                $response['message'] = "Oops! some error occured, please try again";
            }
        } catch (\Exception $e) {
            $response = [
                'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
            ];
            $response['success'] = FALSE;
            Log::error($e->getTraceAsString());
        }
        return $response;
    }

    public function addtocart(Request $request)
    {
        $requestFields = $request->all();
        // Check item is already exist in cart
        $cartObj = Cart::where([
            'restaurant_menu_id' => $requestFields['pid'],
            'user_id' => \Auth::user()->id,
        ])->first();
        if ($cartObj) {
            $cartObj->quantity = $cartObj->quantity + $requestFields['pqty'];
        } else {
            $cartObj = new Cart;
            $cartObj->user_id = \Auth::user()->id;
            $cartObj->restaurant_menu_id = $requestFields['pid'];
            $cartObj->quantity = $requestFields['pqty'];
            $cartObj->price = $requestFields['price'];
        }
        if ($cartObj->save()) {
            return redirect()->route('cart')->with('success', 'Item added to Cart successfull');
        }
        return redirect()->route('cart')->with('error', 'Oops! some error occured, please try again');
    }
}
