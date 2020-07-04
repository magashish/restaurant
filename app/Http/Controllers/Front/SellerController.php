<?php

namespace App\Http\Controllers\Front;

use App\Services\Stripe\Seller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Account;
use Stripe\Exception\ApiErrorException;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use App\SiteSetting;

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
        return view('pages.seller.dashboard');
    }

     public function getaccountdetail(Request $request)
    {
    //    dd(Auth::user()->id);
       $seller_id = Auth::user()->id;
       $host = $request->getHttpHost();
       //$stripe = adminsettings();
       $stripe = SiteSetting::first();

    //    dd($stripe->stripe_s_key);
    //    dd($stripe->stripe_s_key);
       $seller_details = User::where('id', $seller_id)->first();
       if($seller_details['stripe_connect_id'] != NULL)
       {
        //    dd('1');
          $loggedin_seller = Auth::user();
          \Stripe\Stripe::setApiKey($stripe->stripe_s_key);
          $connect_url = \Stripe\Account::createLoginLink($loggedin_seller->stripe_connect_id);
         
          $final_stripe_link_url = trim($connect_url->url,'"');
        //   dd($final_stripe_link_url);
           $acc_is_verified = 1;
           \Stripe\Stripe::setApiKey($stripe->stripe_s_key);           
           $account_detail = \Stripe\Account::retrieve(
               $seller_details['stripe_connect_id']
           );
        //    dd($account_detail);

           // echo "<pre>";print_r($account_detail);die;
           // dd($account_detail->external_accounts->data[0]['account_holder_name']);
           return view('pages.seller.linkaccount',compact('acc_is_verified','account_detail','host','final_stripe_link_url'));
       }
       else
       {
        //    dd('2');
           $acc_is_verified = 0;
           return view('pages.seller.linkaccount',compact('acc_is_verified','host'));
       }
    }

    public function storestripedetail(Request $request)
    {
        $data = $request->all();
        // dd($data);

        // $stripe = adminsettings();
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
        // $stripe = adminsettings();
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



}
