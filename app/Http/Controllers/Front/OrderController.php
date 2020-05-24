<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $data = [];
        $userId = \Auth::user()->id;
        $total = 0;

        $cartData = Cart::where('user_id', $userId)->get()->toArray();

        if(count($cartData) > 0) {
            foreach ($cartData as $cartDatum) {
                $total += $cartDatum['price'] * $cartDatum['quantity'];
            }
        }

        $data['order_total'] = $total;

        return view('pages.checkout.checkout')->with(compact('data'));
    }

    public function placeOrder(Request $request)
    {
        $requestFields = $request->all();
        $userId = \Auth::user()->id;

        // Save shipping address
        $shippingAddressData = $requestFields['shipping_address'];

        if(!empty($shippingAddressData)) {
            $shippingAddressObj = ShippingAddress::where('user_id', $userId)->first();
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
            }
        }

        // Save order
        $orderObj = new Order;
        $orderObj->user_id = $userId;

        $latestOrder = Order::orderBy('created_at','DESC')->first();
        $oid = '#ORDER'.date("ymd").str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
        $orderObj->oid = $oid;
        $orderObj->shipping_address_id = $shippingAddressObj->id;
        $orderObj->save();

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

        return redirect()->route('thank.you', ['oid' => $orderObj->oid]);
    }

    public function thankYou(Request $request)
    {
        $oid = $request->get('oid') ?? "";
        return view('pages.thank-you')->with(compact('oid'));
    }
}
