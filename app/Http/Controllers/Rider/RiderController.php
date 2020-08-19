<?php

namespace App\Http\Controllers\Rider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rider;
use Validator;
use App\Models\Order;
use App\Models\OrderItem;
use Hash;
use App\User;
use App\Models\OrderAddress;
use Auth;

class RiderController extends Controller
{
    
    public function showRegistrationForm()
    {
        return view('pages.rider.register');
    }

    public function register(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:riders'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $data = $request->all();
        // dd($data);
        $riders = new Rider;
        $riders->name = $request->name;
        $riders->email = $request->email;
        $riders->password=Hash::make($request->password);
        $riders->save();
        return redirect()->route('rider.login')->with('success','Account created,Please login now');

    }

    public function checkEmailAddress(Request $request) {
        
        $userName = strtolower(trim($request->input('email')));
        $user = Rider::where('email', '=', $userName)
                ->first();

        if (!empty($user)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function showLoginForm()
    {
        return view('pages.rider.login');
    }

    public function login(Request $request)
    {
        $loginSuccess = Rider::login($request);
        if($loginSuccess) {
            return redirect()->route('rider.dashboard');
        }
        return redirect()->back()->withInput()->with('error', 'Wrong email and password');
    }

    public function dashboard()
    {
        $rider_id = Auth::guard('rider')->user()->id;
        $orders = Order::where('status','DISPATCHED')->orWhere('status','DELIVERED')->where('rider_id',$rider_id)->orderBy('created_at','desc')->with('order_address')->with('user')->with('restraunt')->get();
        return view('pages.rider.dashboard',compact('orders'));
    }

    public function logout()
    {
        Auth::guard('rider')->logout();
        return redirect()->route('rider.login');
    }

    public function riderAccount()
    {
        return view('pages.rider.account');
    }

    public function updateRiderProfile(Request $request)
    {
        $requestFields = $request->all();
        $userObj = Rider::find(\Auth::guard('rider')->user()->id);
        $userObj->name = $requestFields['name'] ?? "";
        $userObj->email = $requestFields['email'] ?? "";
        $userObj->contact_number = $requestFields['contact_number'] ?? "";
        if ($userObj->save()) {
            return redirect()->route('rider.account')->with('success', 'Profile updated successfully');
        }
        return redirect()->route('rider.account')->with('error', GLOBAL_ERROR_MSG);
      
       
    }

    public function riderOrders()
    {
        $rider_id = Auth::guard('rider')->user()->id;
        $get_rider_orders = Order::where('rider_id',$rider_id)->where('status','DELIVERED')->with('user')->with('restraunt')->get();
        return view('pages.rider.orders',compact('get_rider_orders'));
    }
   
}
