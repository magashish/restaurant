<?php

namespace App\Http\Controllers\Front;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function account()
    {
        $data['page'] = "account";
        return view('pages.account.index')->with(compact('data'));
    }

    public function savedAddress()
    {
        $data['page'] = "saved-address";
        $data['addresses'] = ShippingAddress::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->get()->toArray();

        return view('pages.account.saved-address')->with(compact('data'));
    }

    public function deleteAddress($id)
    {
        ShippingAddress::where('id', $id)->delete();

        return redirect()->route('saved.address')->with('success', 'Address delete successfully');
    }
}
