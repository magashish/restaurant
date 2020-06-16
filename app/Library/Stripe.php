<?php

namespace App\Library;

class Stripe
{

    public function __construct($config = [])
    {
        $this->config = $config;
        $stripe = $config;
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY_TEST);
    }

    public function create_charge($data)
    {
        $return = '';
        $contract_data = [
            'customer' => $data['stripe_cus_id'],
            'amount' => $data['amount'] * 100,
            'currency' => $data['currency'],
        ];
        try {
            $contract = \Stripe\Charge::create($contract_data);

            $return = $contract;
        } catch (\Stripe\Error\Base $e) {
            $return = $e->getMessage();
        } catch (Exception $e) {
            $return = $e->getMessage();
        } finally {
            return $return;
        }
    }

    public function create_Transfer($data)
    {
        $return = '';
        $contract_data = [
            'destination' => $data['destination'],
            'amount' => $data['amount'] * 100,
            'currency' => $data['currency'],
            'transfer_group' => $data['transfer_group']
        ];
        try {
            $contract = \Stripe\Transfer::create($contract_data);

            $return = $contract;
        } catch (\Stripe\Error\Base $e) {
            $return = $e->getMessage();
        } catch (Exception $e) {
            $return = $e->getMessage();
        } finally {
            return $return;
        }
    }

    public function createCustomer($data)
    { // create customer on merchant stripe
        $response = '';
        $email = $data['stripeEmail'];
        $source = $data['stripeToken'];
        try {
            $customer = \Stripe\Customer::create([
                'email' => $email,
                //'source' => $source,
                'source' => $source
            ]);

            $response = $customer;
        } catch (\Stripe\Error\Base $e) {
            $response = $e->getMessage();
        } catch (Exception $e) {
            $response = $e->getMessage();
        } finally {
            return $response;
        }
    }

    public function create_coupons($data)
    {
//        echo "<pre>";
//        print_r($data);die;
        $return = '';
        try {
            $coupon = \Stripe\Coupon::create($data);
            $return = $coupon;
        } catch (\Stripe\Error\Base $e) {
            $return = $e->getMessage();
        } catch (Exception $ex) {
            $return = $e->getMessage();
        } finally {
            return $return;
        }
    }

    public function delete_coupon($coupan_id)
    {
        $cpn = \Stripe\Coupon::retrieve($coupan_id);
        $result = $cpn->delete();
        return $result;
    }

    public function check_coupon_code($coupon_code)
    {
        $return = '';
        try {
            $coupon = \Stripe\Coupon::retrieve($coupon_code);
            $return = $coupon;
        } catch (\Stripe\Error\Base $e) {
            $return = $e->getMessage();
        } catch (Exception $ex) {
            $return = $e->getMessage();
        } finally {
            return $return;
        }
    }

    public function check_customer($coupon_code)
    {
        $coupon = \Stripe\Customer::retrieve($coupon_code);
        return $coupon;
    }

    // create connected account
    public function create_connected_account($data)
    {
        $type = 'standard';
        $country = $data['country'];
        $email = $data['email'];
        $return = [];

        try {
            $connected_account = \Stripe\Account::create(array(
                "type" => "standard",
                "country" => $country,
                "email" => $email
            ));

            $return['status'] = 1;
            $return['connected_account'] = $connected_account;
        } catch (\Stripe\Error\Base $e) {
            $return['status'] = 0;
            $return['error'] = $e->getMessage();
        } catch (Exception $e) {
            $return['status'] = 0;
            $return['error'] = $e->getMessage();
        } finally {
            return $return;
        }
    }
}
