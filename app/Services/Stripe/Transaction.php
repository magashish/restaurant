<?php


namespace App\Services\Stripe;


use App\Models\Cart;
use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use App\Payment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Transfer;
use App\Models\Order;

class Transaction
{
    public static function createOld(User $user, Restaurant $restaurant) {

        $amount = 0;
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $data['data'] = Cart::where('user_id', $userId)->with('product_detail')
                ->get()->toArray();
            if(!is_null($data['data'] )) {
                foreach ($data['data'] as $key => $data) {
                    $amount = $amount + $data['price'];
                    $description = $key;
                }
            }

        } else {
            $cart = Session::get('cart');


            if(!empty($cart)) {
                foreach ($cart as $key => $data) {
                    $amount = $amount + $data['price'];
                    $description = $key;
                }
            }
        }

        $payout = $amount * 0.90;
        Stripe::setApiKey(config('services.stripe.secret'));

        //Stripe customer purchase
        try {
            $charge = Charge::create(array(
                "amount" => self::toStripeFormat($amount),
                "currency" => "usd",
                "customer" => $user->stripe_customer_id,
                "description" => $description
                /*"application_fee" => $application_fee,*/
            ));

            Transfer::create([
                "amount" => self::toStripeFormat($payout),
                "currency" => "usd",
                "source_transaction" => $charge->id,
                "destination" => $restaurant->seller->stripe_connecet_id
            ]);
        } catch (ApiErrorException $e) {
            exit($e);
        }

        //save transaction
        $payment = new Payment();
        $payment->customer_id = $user->id;
        $payment->restaurant_menu_id = $restaurant->menu->id;
        $payment->stripe_charge_id = $charge->id;
        $payment->paid_out = $payout;
        $payment->fees_collected = $amount - $payout;
        $payment->save();
    }

    public static function create($orderId, $restaurantId, $userId) {

        $amount = 0;

        $order = Order::find($orderId);
        $restaurant = Restaurant::find($restaurantId);
        $user = User::find($userId);
        $selleObj = User::find($restaurant->seller_id);

        $amount = $order->final_total;

        //$payout = $amount * 0.90;
        $payout = $amount - $order->delivery_charge;
        Stripe::setApiKey(config('services.stripe.secret'));

        //Stripe customer purchase
        try {
            $charge = Charge::create(array(
                "amount" => self::toStripeFormat($amount),
                "currency" => "usd",
                "customer" => $user->stripe_customer_id,
                "description" => $amount
                /*"application_fee" => $application_fee,*/
            ));

            /*Transfer::create([
                "amount" => self::toStripeFormat($payout),
                "currency" => "usd",
                "source_transaction" => $charge->id,
                //"destination" => $restaurant->seller->stripe_connecet_id,
                "destination" => $selleObj->stripe_connect_id,
            ]);*/
        } catch (ApiErrorException $e) {
            exit($e);
        }

        //save transaction
        $payment = new Payment();
        $payment->customer_id = $user->id;
        $payment->restaurant_menu_id = 2;
        $payment->stripe_charge_id = $charge->id;
        $payment->paid_out = $payout;
        $payment->fees_collected = $amount - $payout;
        $payment->save();
    }

    public static function toStripeFormat(float $amount) {
        return $amount * 100;
    }
}
