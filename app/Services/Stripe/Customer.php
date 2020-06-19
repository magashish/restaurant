<?php
namespace App\Services\Stripe;

use App\User;
use Stripe\Stripe;
use Stripe\Token;

class Customer {

	public static function save(User $user, array $card)
	{
		Stripe::setApiKey(config('services.stripe.secret'));

		$token = Token::create($card);
		$customer = \Stripe\Customer::create([
			'source' => $token->id,
			'email' => $user->email,
            'name' => $user->name,
            'address' => [
                'line1' => '510 Townsend St',
                'postal_code' => '98140',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
            ],
		]);

		if($customer) {
		    $userObj = User::find($user->id);
		    $userObj->stripe_customer_id = $customer->id;
		    $userObj->save();
		    //dd($userObj);
            //$user->update(['stripe_customer_id' => $customer->id]);
            return TRUE;
        }
		return FALSE;
	}
}
