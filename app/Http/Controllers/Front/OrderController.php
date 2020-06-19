<?php

namespace App\Http\Controllers\Front;

use App\DeliveryCharge;
use App\Mail\OrderPlcaed;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use App\Models\RestaurantMenuOption;
use App\Models\ShippingAddress;
use App\OrderAddress;
use App\Services\Stripe\Customer;
use App\Services\Stripe\Seller;
use App\Services\Stripe\Transaction;
use App\Tax;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;
use DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $data = [];
        $total = 0;
        $userId = \Auth::user()->id ?? 0;
        $cartData = [];

        $cartExtraItemTotal = 0;

        if (\Auth::check()) {
            $cartData = Cart::where('user_id', $userId)->with('product_detail', 'menu_options', 'menu_options.menu_option_detail')->get()->toArray();

            foreach ($cartData as $key => $menu) {
                foreach ($menu['menu_options'] as $menuOption) {
                    $cartExtraItemTotal += $menuOption['menu_option_detail']['price'];
                }
            }
        } else {
            $cart = Session::get('cart');

            if (!empty($cart)) {
                foreach ($cart as $key => $data) {
                    $cartData[] = [
                        'id' => $key,
                        'user_id' => NULL,
                        'restaurant_menu_id' => $key,
                        'price' => $data['price'],
                        'quantity' => $data['quantity'],
                        'product_detail' => RestaurantMenu::where('id', $key)->first()->toArray()
                    ];

                    $data['extra_items'] = $data['extra_items'] ?? [];
                    foreach ($data['extra_items'] as $extraItemId) {
                        $restaurantMenuOptionObj = RestaurantMenuOption::where('id', $extraItemId)->first();
                        $cartExtraItemTotal += $restaurantMenuOptionObj->price;
                    }
                }
            }
        }

        if (count($cartData) > 0) {
            foreach ($cartData as $cartDatum) {
                $total += $cartDatum['price'] * $cartDatum['quantity'];
            }
            $data['order_total'] = $total + $cartExtraItemTotal;
            $restaurant_menu_id = $cartDatum['restaurant_menu_id'];
            $restaurant_menu = RestaurantMenu::where('id', $restaurant_menu_id)->first();
            $data['restaurant'] = $restaurant_menu->restaurant_id;
            $data['order_total'] = $total;

            $data['saved_addresses'] = ShippingAddress::where('user_id', $userId)->get();

            return view('pages.checkout.checkout')->with(compact('data'));
        }

        return redirect()->route('cart');
    }

    public function calculateDeliveryCharge(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        $requestFields = $request->all();
        $userId = \Auth::user()->id ?? 0;

        try {
            if (\Auth::check()) {
                $cartData = Cart::where('user_id', $userId)->first();
                $restaurantMenuId = $cartData->restaurant_menu_id;

            } else {
                $cart = Session::get('cart');
                $restaurantMenuId = array_key_first($cart);
            }

            $restaurantMenuObj = RestaurantMenu::find($restaurantMenuId);
            $restaurantId = $restaurantMenuObj->restaurant_id;
            $restaurantObj = Restaurant::find($restaurantId);

            $restaurantLat = $restaurantObj->lat;
            $restaurantLng = $restaurantObj->lng;

            //Get location from session
            $sessionLocation = \Session::get('location');

            $userLat = \Auth::user()->lat ?? ($sessionLocation['lat'] ?? $requestFields['data']['user']['lat']);
            $userLng = \Auth::user()->lng ?? ($sessionLocation['lng'] ?? $requestFields['data']['user']['lng']);

            $location = [
                "origin" => [
                    "lat" => $userLat,
                    "lng" => $userLng,
                ],
                "destination" => [
                    "lat" => $restaurantLat,
                    "lng" => $restaurantLng,
                ]
            ];

            $distanceData = calculateDistance($location);

            if ($distanceData['rows'][0]['elements'][0]['status'] === 'OK') {
                $distanceArr = $distanceData['rows'][0]['elements'][0]['distance'];
                $distanceValueArr = explode(" ", $distanceArr['text']);
                $distance = $distanceValueArr[0];
                // Convert distance from miles to km
                $distance = $distance * 1.60934;

                $deliveryChargesObj = DeliveryCharge::whereRaw("$distance between from_location and to_location")->first();

                if ($deliveryChargesObj) {
                    $response['delivery_charge'] = $deliveryChargesObj->price;
                    $response['success'] = TRUE;
                }
            }
        } catch (Exception $ex) {
            $response['error'] = $ex->getMessage() . ' Line No ' . $ex->getLine() . ' in File' . $ex->getFile();
            $response['success'] = FALSE;
        }

        return $response;
    }

    public function checkTax(Request $request)
    {
        $zip = $request->input('zip');
        $tax = Tax::where('zip', $zip)->first();
        $payTax = $tax->tax;
        session(['tax' => $payTax]);

        return json_encode(array('tax' => $payTax));
    }

    public function placeOrder(Request $request)
    {
        $requestFields = $request->all();
        $address = "";
        $orderAddressData = [];
        /*echo "<pre>";
        print_r($requestFields);die;*/

        DB::beginTransaction();

        try {
            $this->validate($request, [
                //'name' => 'required',
                'cc_number' => 'required',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required'
            ]);

            $card = [
                'card' => [
                    'number' => $request->cc_number,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cvv
                ]
            ];

            $shippingAddressData = $requestFields['shipping_address'];

            $isAthenticated = $request->get('is_authenticated');
            if ($isAthenticated == "false" && !is_null($shippingAddressData['email'])) {
                // Register user
                $checkEmailExist = User::where('email', $shippingAddressData['email'])->first();

                if ($checkEmailExist) {
                    return redirect()->route('checkout')->with('error', "Account already exist, pease login to continue");
                }

                $userObj = new User;
                $userObj->name = $shippingAddressData['first_name'] . " " . $shippingAddressData['last_name'];
                $userObj->email = $shippingAddressData['email'];
                $userObj->password = bcrypt($shippingAddressData['password']);
                if ($userObj->save()) {
                    \Auth::loginUsingId($userObj->id);

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
                }
            }

            /*$restaurant_id = $requestFields['restaurant_id'];

            $user = User::where(['id' => \Auth::user()->id])->first();
            $Restaurant = Restaurant::where(['id' => $restaurant_id])->first();
            if($requestFields['payment_method'] === 'stripe') {
                Transaction::create($user, $Restaurant);
            }*/

            $userId = \Auth::user()->id;
            $email = \Auth::user()->email;

            // Create customer stripe id if not exist
            $stripeId = \Auth::user()->stripe_customer_id ?? NULL;
            if (!$stripeId && $requestFields['payment_method'] === 'stripe') {
                $user = Auth::user();
                $customerResponse = Customer::save($user, $card);
                if (!$customerResponse) {
                    return redirect()->back();
                }
            }
            $cartObjResId = Cart::where('user_id', $userId)->first();
            $restaurantMenuId = $cartObjResId->restaurant_menu_id;
            $restaurantMenuObj = RestaurantMenu::find($restaurantMenuId);
            $restaurantId = $restaurantMenuObj->restaurant_id;

            $restaurantObj = Restaurant::find($restaurantId);
            $sellerId = $restaurant->seller->stripe_connecet_id ?? NULL;
            if (!$sellerId && $requestFields['payment_method'] === 'stripe') {
                $customerResponse = Seller::create($restaurantObj);
                if (!$customerResponse) {
                    return redirect()->back();
                }
            }

            // Save shipping address

            if (!empty($shippingAddressData) && isset($requestFields['save_address'])) {
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
                if (isset($requestFields['address_id'])) {
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

            $latestOrder = Order::orderBy('created_at', 'DESC')->first();
            $oid = '#ORDER' . date("ymd") . str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
            $orderObj->oid = $oid;
            $orderObj->amount = $requestFields['order_total'];
            $orderObj->final_total = $requestFields['order_total_final'];
            $orderObj->delivery_charge = $requestFields['delivery_charge'];
            $orderObj->tax = $requestFields['tax'];
            $orderObj->shipping_address_id = $requestFields['address_id'] ?? (isset($requestFields['save_address']) ? $shippingAddressObj->id : NULL);
            $orderObj->shipping_address = $address;
            $orderObj->billing_address = $address;
            if ($orderObj->save()) {
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

            // Make payment
            $userObj = User::find($userId);
            Transaction::create($orderObj->id, $restaurantObj->id, $userId);

            // Commit Transaction
            DB::commit();

            // Send mail
            $orderData = Order::where('id', $orderObj->id)->with('order_item')->first();
            Mail::to($email)->send(new OrderPlcaed($orderData));

            return redirect()->route('thank.you', ['oid' => $orderObj->oid]);
        } catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();
            //return redirect()->route('checkout');
            echo $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();die;
        }
        //return redirect()->route('checkout');
    }

    public function thankYou(Request $request)
    {
        $oid = $request->get('oid') ?? "";
        return view('pages.thank-you')->with(compact('oid'));
    }
}
