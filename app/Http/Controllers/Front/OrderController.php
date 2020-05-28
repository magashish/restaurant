<?php

namespace App\Http\Controllers\Front;

use App\Mail\OrderPlcaed;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantMenu;
use App\Models\ShippingAddress;
use App\OrderAddress;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Session;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $data = [];
        $total = 0;
        $userId = \Auth::user()->id ?? 0;
        $cartData = [];

        if(\Auth::check()) {
            $cartData = Cart::where('user_id', $userId)->get()->toArray();
        } else {
            $cart = Session::get('cart');

            if(!empty($cart)) {
                foreach ($cart as $key => $data) {
                    $cartData[] = [
                        'id' => $key,
                        'user_id' => NULL,
                        'restaurant_menu_id' => $key,
                        'price' => $data['price'],
                        'quantity' => $data['quantity'],
                        'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray()
                    ];
                }
            }
        }

        if(count($cartData) > 0) {
            foreach ($cartData as $cartDatum) {
                $total += $cartDatum['price'] * $cartDatum['quantity'];
            }
            $data['order_total'] = $total;

            $data['saved_addresses'] = ShippingAddress::where('user_id', $userId)->get();

            return view('pages.checkout.checkout')->with(compact('data'));
        }

        return redirect()->route('cart');
    }

    public function placeOrder(Request $request)
    {
        $requestFields = $request->all();
        $address = "";
        $orderAddressData = [];
        /*echo "<pre>";
        print_r($requestFields);die;*/

        $shippingAddressData = $requestFields['shipping_address'];

        $isAthenticated = $request->get('is_authenticated');
        if($isAthenticated == "false") {
            // Register user
            $checkEmailExist = User::where('email', $shippingAddressData['email'])->first();

            if($checkEmailExist) {
                return redirect()->route('checkout')->with('error', "Account already exist, pease login to continue");
            }

            $userObj = new User;
            $userObj->name = $shippingAddressData['first_name'] . " ". $shippingAddressData['last_name'];
            $userObj->email = $shippingAddressData['email'];
            $userObj->password = bcrypt($shippingAddressData['password']);
            if($userObj->save()) {
                \Auth::loginUsingId($userObj->id);

                $cart = Session::get('cart');

                if(!empty($cart)) {
                    foreach ($cart as $key => $data) {
                        $cartObj = new Cart;
                        $cartObj->user_id = \Auth::user()->id;
                        $cartObj->restaurant_menu_id = $key;
                        $cartObj->price = $data['price'];
                        $cartObj->quantity = $data['quantity'];
                        $cartObj->save();
                    }
                }
            }
        }

        $userId = \Auth::user()->id;
        $email = \Auth::user()->email;

        // Save shipping address

        if(!empty($shippingAddressData) && isset($requestFields['save_address'])) {
            /*$shippingAddressObj = ShippingAddress::where('user_id', $userId)->first();
            if(!$shippingAddressObj) {
                $shippingAddressObj = new ShippingAddress;
                $shippingAddressObj->user_id = $userId;
                $shippingAddressObj->first_name = $shippingAddressData['first_name'];
                $shippingAddressObj->last_name = $shippingAddressData['last_name'];
                $shippingAddressObj->email = $shippingAddressData['email'];
                $shippingAddressObj->mobile = $shippingAddressData['mobile'];
                $shippingAddressObj->address = $shippingAddressData['address'];
                $shippingAddressObj->city = $shippingAddressData['city'];
                $shippingAddressObj->state = $shippingAddressData['state'];
                $shippingAddressObj->zip = $shippingAddressData['zip'];
                $shippingAddressObj->save();
            }*/

            $shippingAddressObj = new ShippingAddress;
            $shippingAddressObj->user_id = $userId;
            $shippingAddressObj->first_name = $shippingAddressData['first_name'];
            $shippingAddressObj->last_name = $shippingAddressData['last_name'];
            $shippingAddressObj->email = $shippingAddressData['email'];
            $shippingAddressObj->mobile = $shippingAddressData['mobile'];
            $shippingAddressObj->address = $shippingAddressData['address'];
            $shippingAddressObj->city = $shippingAddressData['city'];
            $shippingAddressObj->state = $shippingAddressData['state'];
            $shippingAddressObj->zip = $shippingAddressData['zip'];
            $shippingAddressObj->save();

            $orderAddressData = ShippingAddress::where('id', $shippingAddressObj->id)->first()->toArray();
        } else {
            if(isset($requestFields['address_id'])) {
                $savedAddressObj = ShippingAddress::where('id', $requestFields['address_id'])->first()->toArray();
                $orderAddressData = $savedAddressObj;

                $address .= $savedAddressObj['first_name'] . " " . $savedAddressObj['last_name'] . ", ";
                $address .= $savedAddressObj['address'] ?? "";
                $address .= $savedAddressObj['city'] ?? "";
                $address .= $savedAddressObj['state'] ?? "";
                $address .= $savedAddressObj['zip'] ?? "";
                $address .= $savedAddressObj['mobile'] ?? "";
            } else {
                $address .= $shippingAddressData['first_name'] . " " . $shippingAddressData['last_name'] . ", ";
                $address .= $shippingAddressData['address'] ?? "";
                $address .= $shippingAddressData['city'] ?? "";
                $address .= $shippingAddressData['state'] ?? "";
                $address .= $shippingAddressData['zip'] ?? "";
                $address .= $shippingAddressData['mobile'] ?? "";

                $orderAddressData = $shippingAddressData;
            }
        }

        // Save order
        $orderObj = new Order;
        $orderObj->user_id = $userId;

        $latestOrder = Order::orderBy('created_at','DESC')->first();
        $oid = '#ORDER'.date("ymd").str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
        $orderObj->oid = $oid;
        $orderObj->shipping_address_id = $requestFields['address_id'] ?? (isset($requestFields['save_address']) ? $shippingAddressObj->id : NULL);
        $orderObj->shipping_address = $address;
        $orderObj->billing_address = $address;
        if($orderObj->save()) {
            // Save order address
            $orderAddressObj = new OrderAddress;
            $orderAddressObj->order_id = $orderObj->id;
            $orderAddressObj->first_name = $orderAddressData['first_name'] ?? "";
            $orderAddressObj->last_name = $orderAddressData['last_name'] ?? "";
            $orderAddressObj->email = $orderAddressData['email'] ?? "";
            $orderAddressObj->mobile = $orderAddressData['mobile'] ?? "";
            $orderAddressObj->address = $orderAddressData['address'] ?? "";
            $orderAddressObj->city = $orderAddressData['city'] ?? "";
            $orderAddressObj->state = $orderAddressData['state'] ?? "";
            $orderAddressObj->zip = $orderAddressData['zip'] ?? "";
            $orderAddressObj->save();
        }

        // Save order item
        $cartItem = Cart::where('user_id', $userId)->get();

        foreach ($cartItem as $item) {
            $orderItemObj = new OrderItem;
            $orderItemObj->order_id = $orderObj->id;
            $orderItemObj->restaurant_menu_id = $item->restaurant_menu_id;
            $orderItemObj->price = $item->price;
            $orderItemObj->quantity = $item->quantity;
            $orderItemObj->save();
        }
        Cart::where('user_id', $userId)->delete();

        // Send mail
        $orderData = Order::where('id', $orderObj->id)->with('order_item')->first();
        Mail::to($email)->send(new OrderPlcaed($orderData));

        return redirect()->route('thank.you', ['oid' => $orderObj->oid]);
    }

    public function thankYou(Request $request)
    {
        $oid = $request->get('oid') ?? "";
        return view('pages.thank-you')->with(compact('oid'));
    }
}
