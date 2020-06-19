<?php
namespace App\Services\Stripe;

use App\Models\Restaurant;
use App\User;
use GuzzleHttp\client;
use Stripe\Stripe;
use Stripe\Token;

class Seller {
	/*public static function create($code)
	{
		$client =  new client(['base_url' => 'https://connect.stripe.com/oauth/']);
		$request = $client->request("POST", "token", [
			"form_params" => [
				"client_secret" => config('services.stripe.secret'),
				"code" => $code,
				"grant_type" => "authorization_code"
			]
		]);
		return json_decode($request->getBody()->getContents());
	}*/

    public static function create(Restaurant $restaurant)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sellerObj = User::find($restaurant->seller_id);

        $customer = \Stripe\Account::create(array(
            "type" => "custom",
            "country" => "US",
            "email" => $sellerObj->email,
            'requested_capabilities' => ['card_payments', 'transfers'],
        ));

        if($customer) {
            $sellerId = $sellerObj->id;
            $userObj = User::find($sellerId);
            $userObj->stripe_connect_id = $customer->id;
            $userObj->save();
            //$restaurant->update(['stripe_connect_id' => $customer->id]);
            return TRUE;
        }
        return FALSE;
    }
}
