<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Auth;
use Session;
use Validator;

class UserController extends Controller
{

    public function register(Request $request)
    {
        // dd('in');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'type' => 'required',
            'password' => 'required|min:8|max:16',
            
            
        ]);
        if ($validator->fails()) {
            $success = false;
            $code =  422;
            $strMessage = '';
            $arrValidatorMsg = (array) json_decode($validator->messages());
            foreach ($arrValidatorMsg as $arrValidMsg) {
                foreach ($arrValidMsg as $strValidMsg) {
                    $strMessage .= $strValidMsg;
                }
            }
         return redirect()->back()->with('error', $strMessage);
        }
            $data = $request->all();
           
            try{
                    $register = new User();
                    $register->name = $data['name'];
                    $register->email = $data['email'];
                    $register->type = $data['type'];
                    $register->name = $data['name'];
                    $register->password = Hash::make($data['password']);
                    $register->save();
                    // dd($register);
                    return redirect()->route('login')->with('success','Account Created,Please Login Now');
                   
            }
            catch(\Illuminate\Database\QueryException $ex){
                return response()->json(['success'=> false, 'error'=> $ex->getMessage()]);
            }
    }

    public function login(Request $request)
    {
        $requestData = $request->all();
     
        try{
            $check_valid = User::where('email',$requestData['email'])->where('type',$requestData['type'])->first();
           
            if($check_valid)
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'type' => 1])) {
                  
                    $cart = Session::get('cart');
                  
                    if (!empty($cart)) {
                        foreach ($cart as $key => $data) {
                            $cartObj = new Cart;
                            $cartObj->user_id = \Auth::user()->id;
                            $cartObj->restaurant_menu_id = $key;
                            $cartObj->price = $data['price'];
                            $cartObj->quantity = $data['quantity'];
                            $cartObj->extra_items = json_encode($data['extra_items'] ?? []);
                            $cartObj->save();
                        }
                    }
                    session(['check_customer_stripe' => auth::user()->stripe_customer_id]);
                   
                    return redirect()->away($requestData['previous_url']);
                    return redirect('/');
                }
                else if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'type' => 2]))
                {
                  
                    return redirect()->route('seller.dashboard');
                    
                }
                else {
                    return redirect('login')->with('error', "Email and password do not match");
                }
            }
            else{
                return redirect('login')->with('error', "No such account is registered with this type");
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['success'=> false, 'error'=> $ex->getMessage()]);
        }
        
       
    }
    public function login2(Request $request)
    {
        $requestData = $request->all();
        $userData = User::where(['email' => $requestData['email']])->first();

        if ($userData && Hash::check($request->password, $userData->password)) {
            Auth::loginUsingId($userData->id);

            $cart = Session::get('cart');
            if (!empty($cart)) {
                foreach ($cart as $key => $data) {
                    $cartObj = new Cart;
                    $cartObj->user_id = \Auth::user()->id;
                    $cartObj->restaurant_menu_id = $key;
                    $cartObj->price = $data['price'];
                    $cartObj->quantity = $data['quantity'];
                    $cartObj->extra_items = json_encode($data['extra_items'] ?? []);
                    $cartObj->save();
                }
            }


            session(['check_customer_stripe' => $userData->stripe_customer_id]);
            return redirect()->away($requestData['previous_url']);
            return redirect('/');
        } else {
            return redirect('login')->with('error', "Email and password do not match");
        }
    }

    public function updateLatLng(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        $requestFields = $request->except('_token');
        try {
            if (\Auth::check()) {
                $userObj = User::find(\Auth::user()->id);
                $userObj->lat = $requestFields['lat'];
                $userObj->lng = $requestFields['lng'];
                $userObj->save();
                $response['success'] = TRUE;
            } else {
                $userLocation = [
                    'lat' => $requestFields['lat'],
                    'lng' => $requestFields['lng'],
                ];

                Session::put('location', $userLocation);
                $response['success'] = TRUE;
            }
        } catch (Exception $ex) {
            $response['error'] = $ex->getMessage() . ' Line No ' . $ex->getLine() . ' in File' . $ex->getFile();
            $response['success'] = FALSE;
        }

        return $response;
    }

    public function updateProfile(Request $request)
    {
        $requestFields = $request->all();

        $userObj = User::find(\Auth::user()->id);
        $userObj->first_name = $requestFields['first_name'] ?? "";
        $userObj->last_name = $requestFields['last_name'] ?? "";
        $userObj->email = $requestFields['email'] ?? "";
        $userObj->mobile = $requestFields['mobile'] ?? "";
        $userObj->city = $requestFields['city'] ?? "";
        $userObj->state = $requestFields['state'] ?? "";
        $userObj->country = $requestFields['country'] ?? "";
        $userObj->zip = $requestFields['zip'] ?? "";
        $userObj->address = $requestFields['address'] ?? "";

        if ($userObj->save()) {
            return redirect()->route('account')->with('success', 'Profile updated successfully');
        }
        return redirect()->route('account')->with('error', GLOBAL_ERROR_MSG);
    }

    public function updateSellerProfile(Request $request)
    {
        $requestFields = $request->all();
        // dd($requestFields);
        $userObj = User::find(\Auth::user()->id);
        $userObj->first_name = $requestFields['first_name'] ?? "";
        $userObj->name = $requestFields['first_name'] ?? "";
        $userObj->last_name = $requestFields['last_name'] ?? "";
        $userObj->email = $requestFields['email'] ?? "";
        $userObj->mobile = $requestFields['mobile'] ?? "";
        $userObj->city = $requestFields['city'] ?? "";
        $userObj->state = $requestFields['state'] ?? "";
        $userObj->country = $requestFields['country'] ?? "";
        $userObj->zip = $requestFields['zip'] ?? "";
        $userObj->address = $requestFields['address'] ?? "";
        if ($userObj->save()) {
            // dd('1');
            return redirect()->route('seller.account')->with('success', 'Profile updated successfully');
        }
        // dd('2');
        return redirect()->route('seller.account')->with('error', GLOBAL_ERROR_MSG);
      
       
    }

    public function changePassword()
    {
        $data['page'] = "change-password";
        return view('pages.account.change-password')->with(compact('data'));
    }

    public function updatePasswordPost(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $requestData = $request->all();
        $userId = \Auth::user()->id;
        $oldPassword = $request->get('old_password');
        $password = $request->get('password');
        try {
            $rules = [
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', implode(" ", $validator->messages()->all()));
            }
            $userObj = User::where('id', $userId)->first();
            if (Hash::check($oldPassword, $userObj->password)) {
                $userObj->password = bcrypt($password);
                if ($userObj->save()) {
                    return redirect()->route('change.password')->with('success', "Passsword changed successfully");
                }
            } else {
                return redirect()->route('change.password')->with('error', 'Wrong old password');
            }
        } catch (\Exception $e) {

        }
        return redirect()->back()->with('error', GLOBAL_ERROR_MSG);
    }
}
