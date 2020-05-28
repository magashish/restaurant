<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AdminController extends Controller
{
    public function login()
    {
        return view('pages.admin.login');
    }

    public function loginPost(Request $request)
    {
        $loginSuccess = Admin::login($request);

        if($loginSuccess) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->withInput()->with('error', 'Wrong email and password');
    }
}
