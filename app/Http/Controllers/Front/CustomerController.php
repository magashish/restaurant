<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Services\Stripe\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function form()
    {
    	return view('stripe.form');
    }

    public function save(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
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

    	$user = Auth::user();
    	Customer::save($user, $card);
    	return back()->with('success', 'Card has been saved. Now proceed with checkout');
    }
}
