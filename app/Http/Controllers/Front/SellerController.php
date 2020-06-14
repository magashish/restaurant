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
        if(is_null($session)) {
            return redirect()->route('restaurantfront.all')->with('error', 'state not found');
        }

        $data = Seller::create($request->code);
        User::find($session->user_id)->update(['stripe_connect_id' => $data->stripe_user_id]);
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
}
