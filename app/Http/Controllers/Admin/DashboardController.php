<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function settings()
    {
        $settingObj = Setting::first();
        $settings = json_decode($settingObj->settings, true);
        return view('pages.admin.settings.settings')->with(compact('settings'));
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
