<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteSetting;
use DB;

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
}
