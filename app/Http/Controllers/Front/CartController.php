<?php

namespace App\Http\Controllers\Front;

use App\CartExtraItem;
use App\Models\Cart;
use App\Models\RestaurantMenu;
use App\Models\RestaurantMenuOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $data['data'] = [];

        if (\Auth::check()) {
            $userId = \Auth::user()->id;
            $data['data'] = Cart::where('user_id', $userId)->with('product_detail', 'menu_options', 'menu_options.menu_option_detail')
                ->get()->toArray();
            /*echo "<pre>";
            print_r($data['data']);die;*/
        } else {
            $cart = Session::get('cart');
            $cartData = [];
            /*echo "<pre>";
            print_r($cart);die;*/

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
                $data['data'] = $cartData;

                /*echo "<pre>";
                print_r($cartData);die;*/
            }
        }

        //echo "<pre>";
        //print_r($data['data']);die;

        return view('pages.cart.index')->with(compact('data'));
    }

    public function updateCart(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['session_cart'] = FALSE;

        $requestFields = $request->all();

        try {
            if(\Auth::check()) {
                $cardObj = Cart::find($requestFields['cart_id']);

                $cardObj->quantity = $requestFields['quantity'];
                if ($cardObj->save()) {
                    $response['success'] = TRUE;

                    $userId = \Auth::user()->id;
                    $cartData = Cart::where('user_id', $userId)->with('product_detail')
                        ->get()->toArray();

                    $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();
                } else {
                    $response['message'] = "Oops! some error occured, please try again";
                }
            } else {
                $response['success'] = TRUE;
                $response['session_cart'] = TRUE;
                $cart = Session::get('cart');

                /*
                 * If product already exist into the cart then update QTY of product
                 * Othewise add new product into the cart
                 */
                if(isset($cart[$requestFields['cart_id']])) {
                    $cart[$requestFields['cart_id']]['quantity'] = $requestFields['quantity'];
                }

                $cartData = [];
                if(!empty($cart)) {
                    foreach ($cart as $key => $value) {
                        $cartData[] = [
                            'id' => $key,
                            'restaurant_menu_id' => $key,
                            'price' => $value['price'],
                            'quantity' => $value['quantity'],
                            'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray()
                        ];
                    }
                }
                $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();
                Session::put('cart', $cart);
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
        $response['session_cart'] = FALSE;

        $requestFields = $request->all();

        try {
            if(Auth::check()) {
                if (Cart::where('id', $requestFields['cart_id'])->delete()) {
                    $response['success'] = TRUE;

                    $userId = \Auth::user()->id;
                    $cartData = Cart::where('user_id', $userId)->with('product_detail')
                        ->get()->toArray();

                    $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();
                } else {
                    $response['message'] = "Oops! some error occured, please try again";
                }
            } else {
                $response['success'] = TRUE;
                $response['session_cart'] = TRUE;
                $cart = Session::get('cart');

                /*
                 * If product already exist into the cart then update QTY of product
                 * Othewise add new product into the cart
                 */
                if(isset($cart[$requestFields['cart_id']])) {
                    unset($cart[$requestFields['cart_id']]);
                }

                $cartData = [];
                if(!empty($cart)) {
                    foreach ($cart as $key => $value) {
                        $cartData[] = [
                            'id' => $key,
                            'restaurant_menu_id' => $key,
                            'price' => $value['price'],
                            'quantity' => $value['quantity'],
                            'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray()
                        ];
                    }
                }
                $response['html'] = view('pages.cart.partial.cart')->with(compact('cartData'))->render();

                Session::put('cart', $cart);
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
        if (\Auth::check()) {
            $cartObj = Cart::where([
                'restaurant_menu_id' => $requestFields['pid'],
                'user_id' => \Auth::user()->id,
            ])->first();
            if ($cartObj) {
                $cartObj->quantity = $cartObj->quantity + $requestFields['pqty'];
                $cartObj->extra_items = json_encode($requestFields['itemoption'] ?? []);
            } else {
                $cartObj = new Cart;
                $cartObj->user_id = \Auth::user()->id;
                $cartObj->restaurant_menu_id = $requestFields['pid'];
                $cartObj->quantity = $requestFields['pqty'];
                $cartObj->price = $requestFields['price'];
                $cartObj->extra_items = json_encode($requestFields['itemoption'] ?? []);
            }
            if ($cartObj->save()) {
                // Delete old data
                CartExtraItem::where('cart_id', $cartObj->id)->delete();

                foreach ($requestFields['itemoption'] as $cartOption) {
                    $cartExtraItemObj = new CartExtraItem;
                    $cartExtraItemObj->cart_id = $cartObj->id;
                    $cartExtraItemObj->restaurant_menu_option_id = $cartOption;
                    $cartExtraItemObj->save();
                }

                if(isset($requestFields['previous_url']) && !empty($requestFields['previous_url'])) {
                    return redirect()->away($requestFields['previous_url'])->with('success', 'Item added to Cart successfull');
                } else {
                    return redirect()->route('cart')->with('success', 'Item added to Cart successfull');
                }
            }
        } else {
            $prodId = $request->post('pid');
            $cart = Session::get('cart');

            /*
             * If product already exist into the cart then update QTY of product
             * Othewise add new product into the cart
             */
            if(isset($cart[$prodId])):
                $cart[$prodId]['quantity'] += 1;
            else:
                $product = [
                    "name" => $request->post('pname'),
                    "quantity" => $request->post('pqty'),
                    "price" => $request->post('price'),
                    "photo" => $request->post('image'),
                    "extra_items" => $request->post('itemoption'),
                ];
                $cart[$prodId] = $product;
            endif;

            Session::put('cart', $cart);
        }
        $cart = session()->get('cart');
        //dd($cart);
        if(isset($requestFields['previous_url']) && !empty($requestFields['previous_url'])) {
            return redirect()->away($requestFields['previous_url'])->with('error', 'Oops! some error occured, please try again');
        } else {
            return redirect()->route('cart')->with('error', 'Oops! some error occured, please try again');
        }
    }

    public function checkSameRestaurant(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['can_add'] = FALSE;
        if(\Auth::check()) {
            $cartMenuItem = Cart::select('restaurant_menu_id')->where('user_id', \Auth::user()->id)->pluck('restaurant_menu_id')->toArray();
        } else {
            $menuIds = [];
            $cart = Session::get('cart');

            if(!empty($cart)) {
                $menuIds = array_keys($cart);
                $cartMenuItem = $menuIds;
            }
        }

        if(empty($cartMenuItem)) {
            $response['success'] = TRUE;
            $response['can_add'] = TRUE;
            return $response;
        }

        $cartRestaurantIds = RestaurantMenu::select('restaurant_id')->whereIn('id', $cartMenuItem)->pluck('restaurant_id')->toArray();
        $cartRestaurantIds = array_unique($cartRestaurantIds);

        $addToCartMenuObj = RestaurantMenu::select('restaurant_id')->where('id', $request->get('menu_id'))->first();
        $restaurantId = $addToCartMenuObj->restaurant_id;

        if($cartRestaurantIds[0] == $restaurantId) {
            $response['success'] = TRUE;
            $response['can_add'] = TRUE;
        }
        return $response;
    }
}
