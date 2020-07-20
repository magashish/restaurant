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
use Stripe;
use App\SiteSetting;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $data = [];
        $total = 0;
        $userId = \Auth::user()->id ?? 0;
        $cartData = [];

        $cartExtraItemTotal = 0;
        $stripe = SiteSetting::first();
        
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

            $zip = \Auth::user()->zip ?? NULL;
            $zipTax = NULL;
            if($zip) {
                $taxObj = Tax::where('zip', $zip)->first();

                if($taxObj) {
                    $zipTax = $taxObj->tax;
                }
            }
          
            return view('pages.checkout.checkout')->with(compact('data', 'zipTax','stripe'));
        }

        return redirect()->route('cart');
    }

    public function calculateDeliveryCharge(Request $request)
    {
    
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
           
            if($userLat == 0)
            {
                return response()->json([
                    'status' => 'error',
                    'delivery_charge' => 0,
                    'message' => 'User do not have lat and long'
                ]);  
                echo $response;
                exit();
            }
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
            $admin_setting = SiteSetting::where('id',1)->first();
            $g_key = $admin_setting['google_key'];
            $distanceData = calculateDistance($location,$g_key);
            if ($distanceData['rows'][0]['elements'][0]['status'] === 'OK') {
               
                $distanceArr = $distanceData['rows'][0]['elements'][0]['distance'];
                $distanceValueArr = explode(" ", $distanceArr['text']);
                $distance = $distanceValueArr[0];
                if($distanceValueArr[1] == 'm')
                {
                    $b = str_replace( ',', '', $distance);
                    $distance = $b;
                    // Convert distance from m to miles
                    $distance = $distance * 0.0006213712;
                }
                elseif($distanceValueArr[1] == 'km')
                {
                    $b = str_replace( ',', '', $distance);
                    $distance = $b;
                    // Convert distance from km to miles
                    $distance = $distance * 0.621371;
                }
                if($distance > 20)
                {
                    return response()->json([
                        'status' => 'error',
                        'delivery_charge' => 0,
                        'message' => 'This restraunt can not serve you at your location'
                    ]);  
                    echo $response;
                    exit();
                }
               
               $get_delivery = DeliveryCharge::all();
               $price = 0;
               foreach($get_delivery as $key=> $delivery)
               {
                   $dis = $delivery['distance'];
                  
                   $dis_exp = explode("-", $dis);
                   
                   $float1 = (float)$dis_exp[0];
                   $float2 = (float)$dis_exp[1];
                   if(($float1<=$distance) && $float2>=$distance )
                   {
                        $price = $delivery['price'];
                        break;
                   }
               }
                if ($get_delivery) {
                    return response()->json([
                        'status' => 'success',
                        'delivery_charge' => $price,
                        'message' => 'Delivery Price Fetched Successfully'
                    ]);  
                    echo $response;
                    exit();
                }
            }
        } catch (Exception $ex) {
            $response['error'] = $ex->getMessage() . ' Line No ' . $ex->getLine() . ' in File' . $ex->getFile();
            $response['success'] = FALSE;
        }

    }

    public function inputcalculateDeliveryCharge(Request $request)
    {
    
        if($request->ajax())
        {
            $requestFields = $request->all();
       
            if($requestFields['data']['user']['address'] == null)
            {
              
                return response()->json([
                    'status' => 'error',
                    'delivery_charge' => 0,
                    'message' => 'Please Enter the Address'
                ]);  
                echo $response;
                exit();
            }
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
                // Get lat lng
            $fullAddressArr = [
                $requestFields['data']['user']['address'],
             
                $requestFields['data']['user']['city'],
                $requestFields['data']['user']['state'],
                $requestFields['data']['user']['country'],
            ];
           
            $address_tmp = implode(", ", $fullAddressArr);
            $address_tmp = str_replace(" ", "+", $address_tmp);
        //    dd($address_tmp);
            $res = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $address_tmp . "&key=AIzaSyDpavHXELJMJvIHifFPN6tBBiFSXKGpy2g");
           
            $address_res = json_decode($res, TRUE);
           
            $userLat = $address_res['results'][0]['geometry']['location']['lat'];
            $userLng = $address_res['results'][0]['geometry']['location']['lng'];
            // dd($userLat,$userLng);
                if($userLat == 0)
                {
                    return response()->json([
                        'status' => 'error',
                        'delivery_charge' => 0,
                        'message' => 'Please enter the nearest point to your address'
                    ]);  
                    echo $response;
                    exit();
                }
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
                $admin_setting = SiteSetting::where('id',1)->first();
                $g_key = $admin_setting['google_key'];
                $distanceData = calculateDistance($location,$g_key);
                // dd($distanceData);
                if ($distanceData['rows'][0]['elements'][0]['status'] === 'OK') {
                   
                    $distanceArr = $distanceData['rows'][0]['elements'][0]['distance'];
                    $distanceValueArr = explode(" ", $distanceArr['text']);
                    $distance = $distanceValueArr[0];
                    if($distanceValueArr[1] == 'm')
                    {
                        $b = str_replace( ',', '', $distance);
                        $distance = $b;
                        // Convert distance from m to miles
                        $distance = $distance * 0.0006213712;
                        
                    }
                    elseif($distanceValueArr[1] == 'km')
                    {
                        $b = str_replace( ',', '', $distance);
                        $distance = $b;
                        // Convert distance from km to miles
                        $distance = $distance * 0.621371;
                        // dd($distance);
                    }
                   
                    if($distance > 20)
                    {
                        return response()->json([
                            'status' => 'error',
                            'delivery_charge' => 0,
                            'message' => 'This restraunt can not serve you at your location'
                        ]);  
                        echo $response;
                        exit();
                    }
                   $get_delivery = DeliveryCharge::all();
                   $price = 0;
                   foreach($get_delivery as $key=> $delivery)
                   {
                       $dis = $delivery['distance'];
                      
                       $dis_exp = explode("-", $dis);
                   
                       $float1 = (float)$dis_exp[0];
                       $float2 = (float)$dis_exp[1];
                       
                       if(($float1<=$distance) && $float2>=$distance )
                       {
                            $price = $delivery['price'];
                            
                            break;
                       }
                   }
                    if ($get_delivery) {
                        return response()->json([
                            'status' => 'success',
                            'delivery_charge' => $price,
                            'message' => 'Delivery Price Fetched Successfully'
                        ]);  
                        echo $response;
                        exit();
                    }
                }
            } catch (Exception $ex) {
                $response['error'] = $ex->getMessage() . ' Line No ' . $ex->getLine() . ' in File' . $ex->getFile();
                $response['success'] = FALSE;
            }
    
        }
       
    }

    public function checkTax(Request $request)
    {
      
        $requestFields = $request->all();
        $zip = \Auth::user()->zip ?? ($sessionLocation['zip'] ?? $requestFields['zip']);
        $tax = Tax::where('zip', $zip)->first();
       
        if(!$tax)
        {
            return response()->json([
                'status' => 'error',
                'tax' => 0
            ]); 
            echo $response;
            exit(); 
        }else{
            $payTax = $tax->tax;
            session(['tax' => $payTax]);
            return response()->json([
                'status' => 'success',
                'tax' => $payTax
            ]); 
            echo $response;
            exit();
        }
       
    }

    public function inputcheckTax(Request $request)
    {
      
        $requestFields = $request->all();
        
        $zip = $requestFields['zip'];
       
        $tax = Tax::where('zip', $zip)->first();
        
        if(!$tax)
        {
            return response()->json([
                'status' => 'error',
                'tax' => 0
            ]); 
            echo $response;
            exit(); 
        }else{
            $payTax = $tax->tax;
            session(['tax' => $payTax]);
            return response()->json([
                'status' => 'success',
                'tax' => $payTax
            ]); 
            echo $response;
            exit();
        }
        
    }

    public function placeOrder(Request $request)
    {
        if($request->ajax())
        {
            $requestFields = $request->all();
            // dd($requestFields);
            $address = "";
            $orderAddressData = [];
            DB::beginTransaction();
    
            try {
               
                $shippingAddressData = $requestFields['shipping_address'];
                
                $isAthenticated = $request->get('is_authenticated');
                if ($isAthenticated == "false" && !is_null($shippingAddressData['2'])) {
                    // Register user
                  
                    $checkEmailExist = User::where('email', $shippingAddressData['2'])->first();
    
                    if ($checkEmailExist) {
                        // return redirect()->route('checkout')->with('error', "Account already exist, pease login to continue");
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This Email already exists,Please try with a different email address'
                        ]);  
                        echo $response;
                        exit();
                    }
    
                    $userObj = new User;
                    $userObj->name = $shippingAddressData['0'] . " " . $shippingAddressData['1'];
                    $userObj->email = $shippingAddressData['2'];
                    $userObj->password = bcrypt($shippingAddressData['4']);
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
                $userId = \Auth::user()->id;
                $username = \Auth::user()->first_name;
                $email = \Auth::user()->email;
                $stripe = SiteSetting::first();
                Stripe\Stripe::setApiKey($stripe->stripe_s_key);
                // Create customer stripe id if not exist
                $stripeId = \Auth::user()->stripe_customer_id ?? NULL;
                $user = Auth::user();
                if (!$stripeId && $requestFields['paymentMethod'] === 'stripe') {
                   
                    // $customerResponse = Customer::save($user, $card);
                    try {
                        $customerResponse = \Stripe\Customer::create([
                            "description" => $user->email,
                            "source" => $request->stripetoken, // obtained with Stripe.js
                        ]);
                        } catch(\Stripe\Exception\CardException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => 'Your payment has been declined. Please check with your credit card company or try another card',
                        ]);
                        } catch(\Stripe\Exception\RateLimitException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        ]);
                        } catch (\Stripe\Exception\InvalidRequestException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        ]);
                        } catch (\Stripe\Exception\AuthenticationException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        ]);
                        } catch (\Stripe\Exception\ApiConnectionException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        ]);
                        } catch (\Stripe\Exception\ApiErrorException $e) {
                        return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        ]);
                    }
                    if (!$customerResponse) {
                        // return redirect()->back();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Please try after some time'
                        ]);  
                        echo $response;
                        exit();
                    }
                    $user->stripe_customer_id = $customerResponse['id'];
                    $user->card_token = $customerResponse['default_source'];
                    // $user->save();
                }
                $cartObjResId = Cart::where('user_id', $userId)->first();
                
                $restaurantMenuId = $cartObjResId->restaurant_menu_id;
                
                $restaurantMenuObj = RestaurantMenu::find($restaurantMenuId);
                
                $restaurantId = $restaurantMenuObj->restaurant_id;
                
                $restaurantObj = Restaurant::find($restaurantId);
               
                $seller_details = User::where('id',$restaurantObj['seller_id'])->first();
                
                $seller_stripe_connect_id = $seller_details['stripe_connect_id'];
                //$sellerId = $restaurant->seller->stripe_connecet_id ?? NULL;
                if (!$seller_stripe_connect_id && $requestFields['paymentMethod'] === 'stripe') {
                    // $customerResponse = Seller::create($restaurantObj);
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Stripe Payments are not applicable for this restraunt'
                        ]);  
                        echo $response;
                        exit();
                }
    
                // Save shipping address
                if (!empty($shippingAddressData) && isset($requestFields['save_address'])) {
                    $shippingAddressObj = new ShippingAddress;
                    $shippingAddressObj->user_id = $userId;
                    $shippingAddressObj->first_name = $shippingAddressData['0'];
                    $shippingAddressObj->last_name = $shippingAddressData['1'];
                    $shippingAddressObj->email = $shippingAddressData['2'];
                    $shippingAddressObj->mobile = $shippingAddressData['3'];
                    $shippingAddressObj->address = $shippingAddressData['6'];
                    $shippingAddressObj->city = $shippingAddressData['7'];
                    $shippingAddressObj->state = $shippingAddressData['8'];
                    $shippingAddressObj->zip = $shippingAddressData['9'];
                    $shippingAddressObj->save();
                    $orderAddressData = ShippingAddress::where('id', $shippingAddressObj->id)->first()->toArray();
                    //  Save order
                    //  dd($address);
                    $orderObj = new Order;
                    $orderObj->user_id = $userId;
                    $orderObj->seller_id = $restaurantObj['seller_id'];
                    $orderObj->restraunt_id = $restaurantId;
                    $orderObj->status = 'RECEIVED';
                    $latestOrder = Order::orderBy('created_at', 'DESC')->first();
                    $oid = '#ORDER' . date("ymd") . str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
                    $orderObj->oid = $oid;
                    $orderObj->amount = $requestFields['order_total'];
                    $orderObj->final_total = $requestFields['order_total_final'];
                    $orderObj->delivery_charge = $requestFields['delivery_charge_hidden'];
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
    
                            // Save order
                            // dd($address);
                        $orderObj = new Order;
                        $orderObj->user_id = $userId;
                        $orderObj->seller_id = $restaurantObj['seller_id'];
                        $orderObj->restraunt_id = $restaurantId;
                        $orderObj->status = 'RECEIVED';
                        $latestOrder = Order::orderBy('created_at', 'DESC')->first();
                        $oid = '#ORDER' . date("ymd") . str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
                        $orderObj->oid = $oid;
                        $orderObj->amount = $requestFields['order_total'];
                        $orderObj->final_total = $requestFields['order_total_final'];
                        $orderObj->delivery_charge = $requestFields['delivery_charge_hidden'];
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
    
                    } else {
                        //dd($shippingAddressData);
                        $address .= $shippingAddressData['0'] . " " . $shippingAddressData['1'] . ", ";
                        $address .= $shippingAddressData['6'] . ", " ?? "";
                        // dd($shippingAddressData['9']);
                        // $address .= $shippingAddressData['7'] ?? "";
                        // $address .= $shippingAddressData['8'] ?? "";
                        $address .= $shippingAddressData['9'] ?? "";
                        // $address .= $shippingAddressData['3'] ?? "";
                        $orderAddressData = $shippingAddressData;
                        // dd($address);
                         // Save order
                        $orderObj = new Order;
                        $orderObj->user_id = $userId;
                        $orderObj->seller_id = $restaurantObj['seller_id'];
                        $orderObj->status = 'RECEIVED';
                        $orderObj->restraunt_id = $restaurantId;
                        $latestOrder = Order::orderBy('created_at', 'DESC')->first();
                        $oid = '#ORDER' . date("ymd") . str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT);
                        $orderObj->oid = $oid;
                        $orderObj->amount = $requestFields['order_total'];
                        $orderObj->final_total = $requestFields['order_total_final'];
                        $orderObj->delivery_charge = $requestFields['delivery_charge_hidden'];
                        $orderObj->tax = $requestFields['tax'];
                        $orderObj->shipping_address_id = $requestFields['address_id'] ?? (isset($requestFields['save_address']) ? $shippingAddressObj->id : NULL);
                        $orderObj->shipping_address = $address;
                        $orderObj->billing_address = $address;
                        if ($orderObj->save()) {
                            // Save order address
                            $orderAddressObj = new OrderAddress;
                            $orderAddressObj->order_id = $orderObj->id;
                            $orderAddressObj->first_name = $orderAddressData['0'] ?? "";
                            $orderAddressObj->last_name = $orderAddressData['1'] ?? "";
                            $orderAddressObj->email = $orderAddressData['2'] ?? "";
                            $orderAddressObj->mobile = $orderAddressData['3'] ?? "";
                            $orderAddressObj->address = $orderAddressData['6'] ?? "";
                            $orderAddressObj->city = $orderAddressData['7'] ?? "";
                            $orderAddressObj->state = $orderAddressData['8'] ?? "";
                            $orderAddressObj->zip = $orderAddressData['9'] ?? "";
                            $orderAddressObj->save();
                        }
                    }
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
                $seller_amount = $requestFields['order_total'] + $requestFields['tax'];
                //Transaction::create($orderObj->id, $restaurantObj->id, $userId);
                if ($requestFields['paymentMethod'] === 'stripe')
                {
                    try {
                        $Charge = \Stripe\PaymentIntent::create([
                        'amount' => $requestFields['order_total_final'] * 100,
                        'currency' => 'usd',
                        'customer' => $user->stripe_customer_id,
                        'payment_method' => $user->card_token,
                        'confirmation_method' => 'automatic',
                        "description" => 'Test Payment by Dev Team',
                        'confirm' => true,
                        'application_fee_amount' => '20',
                        'transfer_data' => [
                        'destination' => $seller_details['stripe_connect_id'],
                        ],
                    ]);
                    } catch(\Stripe\Exception\CardException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => 'Your payment has been declined. Please check with your credit card company or try another card',
                    ]);
                    } catch(\Stripe\Exception\RateLimitException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    ]);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    ]);
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    ]);
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    ]);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                    return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    ]);
                    }
                }
              
                // Commit Transaction
                DB::commit();
                // Send mail
                $orderData = Order::where('id', $orderObj->id)->with('order_item')->first();
                // Mail::to($email)->send(new OrderPlcaed($orderData));
                // return redirect()->route('thank.you', ['oid' => $orderObj->oid]);
                return response()->json([
                    'status' => 'success',
                    'oid' =>  $orderObj->oid,
                    'message' => 'Your Order has been placed Successfully'
                ]);  
                echo $response;
                exit();
            } catch (\Exception $e) {
                // Rollback Transaction
                DB::rollback();
                echo $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();die;
            }
        }
       
    }

    public function thankYou(Request $request)
    {
        $oid = $request->get('oid') ?? "";
        return view('pages.thank-you')->with(compact('oid'));
    }

    public function myOrders(Request $request)
    {
        $data = [];
        $data['page'] = "my-orders";
        $data['orders'] = Order::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->with('order_item', 'order_item.item_detail')->get();
        //dd($data['orders']);

        return view('pages.account.my-orders')->with(compact('data'));
    }

    public function orderDetail($oid)
    {
        $data = [];
        $data['page'] = "my-orders";
        $order = Order::where('oid', "#" . $oid)->with('order_item', 'order_item.item_detail')->first();
        //dd($order);

        return view('pages.account.order-detail')->with(compact('data', 'order'));
    }
}
