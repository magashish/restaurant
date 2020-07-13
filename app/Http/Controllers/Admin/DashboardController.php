<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteSetting;
use DB;
use App\DeliveryCharge;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function settings(Request $request)
    {
        $settingObj = SiteSetting::first();
        if($request->isMethod('post'))
        {
            $data = $request->all();
            DB::table('site_settings')->where('id',1)->update([
                'stripe_s_key' => $data['stripe_s_key'],
                'stripe_p_key' => $data['stripe_p_key'],
                'google_key' => $data['google_key']
            ]);
            return redirect()->route('admin.settings');
        }
        return view('pages.admin.settings.settings')->with(compact('settingObj'));
    }

    public function saveSettings(Request $request)
    {
        $requestFields = $request->all();

        $settingObj = Setting::first();

        if(!$settingObj) {
            $settingObj = new Setting;
        }

        $settingObj->settings = json_encode($requestFields['settings']);

        if($settingObj->save()) {
            return redirect()->route('admin.settings')
                ->with('success', 'Settings updated successfully');
        }
        return redirect()->route('admin.settings')
            ->with('error', 'Oops! some error occured, please try again');
    }

    public function deliveryCharges()
    {
        return view('pages.admin.delivery.set_charges');
    }

    public function postDeliveryCharges(Request $request)
    {
        $data = $request->all();
        $check_if_alredy_priced = DeliveryCharge::where('distance',$data['select_distance'])->first();
        if($check_if_alredy_priced)
        {
            DB::table('delivery_charges')->where('id',$check_if_alredy_priced['id'])->update([
                'price' => $data['price']
            ]);
            return redirect()->route('delivery.prices')->with('success','Price Added');
        }
        else{
            $save_delivery_price = new DeliveryCharge();
            $save_delivery_price->distance = $data['select_distance'];
            $save_delivery_price->price = $data['price'];
            $save_delivery_price->save();
            return redirect()->route('delivery.prices')->with('success','Price Added');
        }
       
    }

    public function viewDeliveryCharges()
    {
        $view_delivery_prices = DeliveryCharge::orderBy('created_at','asc')->paginate(10);
        return view('pages.admin.delivery.view_charges',compact('view_delivery_prices'));

    }

    public function editDeliveryCharges(Request $request,$id)
    {
       
        if($request->isMethod('post'))
        {
            $data = $request->all();
            DB::table('delivery_charges')->where('id',$id)->update([
                'price' => $data['price']
            ]);
            return redirect()->route('delivery.prices')->with('success','Price Updated');

        }
        $get_price_detail = DeliveryCharge::where('id',$id)->first();
        return view('pages.admin.delivery.edit_charges',compact('get_price_detail'));
        
    }
}
