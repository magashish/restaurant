<?php

namespace App\Http\Controllers\Front;

use App\Services\Stripe\Seller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Account;
use App\Models\Order;
use Stripe\Exception\ApiErrorException;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\Models\OrderAddress;
use App\Rider;
use App\SiteSetting;
use App\Models\OrderItem;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function create()
    {
    	$user = Auth::user();
    	if(!is_null($user->stripe_connect_id)) {
    		return redirect()->route('stripe_login');
    	}

    	$session = \request()->session()->getId();

    	$url = config('services.stripe.connect') . $session;

    	return redirect($url);
    }

    public function save(Request $request) {
        $this->validate($request, [
            'code' => 'required',
            'state' => 'required',
        ]);

        $session = DB::table('sessions')->where('id', $request->state)->first();
        $user = Auth::user();
        if(is_null($user)) {
            return redirect()->route('restaurantfront.all')->with('error', 'state not found');
        }

        $data = Seller::create($request->code);
        User::find($user->id)->update(['stripe_connect_id' => $data->stripe_user_id]);
        return redirect()->route('restaurantfront.all')->with('success', 'Account Information has been saved');
    }

    public function login() {
        $user = Auth::user();
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $account_link = Account::createLoginLink($user->stripe_connect_id);
        } catch (ApiErrorException $e) {
            print_r($e);
            exit();
        }

        return redirect($account_link->url);
    }

    public function dashboard()
    {
        $seller_id = Auth::user()->id;
        // dd($seller_id);
        // $riders = Rider::where('status','FREE')->get();
        $orders = Order::where('seller_id',$seller_id)->where('status','RECEIVED')->orWhere('status','PREPARING')->orWhere('status','DISPATCHED')->orderBy('created_at','desc')->with('order_address')->with('user')->with('restraunt')->get();
        return view('pages.seller.dashboard',compact('orders'));
    }

    public function getRiders(Request $request)
    {
        $data = $request->all();
        $riders = Rider::where('status','FREE')->get();
        return response()->json([
            'status' => 'success',
            'riders' => $riders,
            'order_id' => $data['order_id'],
            'message' => 'Available Riders Fetched Successfully'
        ]);  
        echo $response;
        exit();
    }

    public function updateRider(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $update_rider = Order::find($data['order_id']);
        $update_rider->rider_id = $data['rider_id'];
        $update_rider->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Rider Aligned Successfully'
        ]);  
        echo $response;
        exit();
    }

    public function orderDetails(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            $get_order_details = OrderItem::where('order_id',$data['order_id'])->with('item_detail')->get();
            return response()->json([
                'status' => 'success',
                'user_name' => $data['user_name'],
                'user_mobile' => $data['user_mobile'],
                'order_total' => $data['order_total'],
                'final_total' => $data['final_total'],
                'tax' => $data['tax'],
                'delivery_charge' => $data['delivery_charge'],
                'data' => $get_order_details,
                'message' => 'Details Fetched Successfully',
                ]);
        }
    }

    public function viewDetails($id)
    {
        $get_details = OrderItem::where('order_id',$id)->with('order')->with('item_detail')->get();
        $order_details = Order::where('id',$id)->first();
        return view('pages.seller.order_details',compact('get_details','order_details'));
    }

     public function getaccountdetail(Request $request)
    {
       $seller_id = Auth::user()->id;
       $host = $request->getHttpHost();
       $stripe = SiteSetting::first();
       $seller_details = User::where('id', $seller_id)->first();
       if($seller_details['stripe_connect_id'] != NULL)
       {
          $loggedin_seller = Auth::user();
          \Stripe\Stripe::setApiKey($stripe->stripe_s_key);
          $connect_url = \Stripe\Account::createLoginLink($loggedin_seller->stripe_connect_id);
          $final_stripe_link_url = trim($connect_url->url,'"');
           $acc_is_verified = 1;
           \Stripe\Stripe::setApiKey($stripe->stripe_s_key);           
           $account_detail = \Stripe\Account::retrieve(
               $seller_details['stripe_connect_id']
           );
           return view('pages.seller.linkaccount',compact('acc_is_verified','account_detail','host','final_stripe_link_url'));
       }
       else
       {
           $acc_is_verified = 0;
           return view('pages.seller.linkaccount',compact('acc_is_verified','host'));
       }
    }

    public function storestripedetail(Request $request)
    {
        $data = $request->all();
        $stripe = SiteSetting::first();
        $seller_id = Auth::user()->id;
        $seller = User::where('id', $seller_id)->first();
        \Stripe\Stripe::setApiKey($stripe->stripe_s_key);
        $response = \Stripe\OAuth::token([
          'grant_type' => 'authorization_code',
          'code' => $data['code'],
          'suggested_capabilities' => ['card_payments'],
        ]);
        // Access the connected account id in the response
        $connected_account_id = $response->stripe_user_id;
        $seller->stripe_connect_id = $connected_account_id;
        $seller->save();
        return redirect('link-bank-account');
    }

    public function deletestripeaccount(Request $request)
    {
        $sellerid = Auth::user()->id;
        $stripe = SiteSetting::first();
        $seller = User::where('id', $sellerid)->first();
        \Stripe\Stripe::setApiKey($stripe->stripe_s_key);
        $account = \Stripe\Account::retrieve(
          $seller->stripe_connect_id
        );
        $account->delete();
        $seller->stripe_connect_id = NULL;
        $seller->save();
        return redirect('link-bank-account')->with('success','Account successfully removed!');
    }

    public function sellerOrders()
    {
        $seller_id = Auth::user()->id;
        $get_seller_orders = Order::where('seller_id',$seller_id)->where('status','DELIVERED')->with('user')->with('restraunt')->get();
        return view('pages.seller.orders',compact('get_seller_orders'));
    }

    public function changeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            DB::table('orders')->where('id',$data['order_id'])->update([
                'status' => $data['status']
            ]);
            return response()->json([
                'status' => 'success',
                'order_id' => $data['order_id'],
                'message' => 'Order Status Updated Successfully',
                ]);
        }
    }


}
