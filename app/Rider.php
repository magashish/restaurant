<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\User as Model;

class Rider extends Model
{
    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword()
    {
        return $this->password;
    }

    public static function login($request)
    {
        $requestData = $request->all();
        // dd($requestData);
        if (Auth::guard('rider')->attempt(['email' => $requestData['email'], 'password' => $requestData['password']]))
            return TRUE;

        return FALSE;


        // if (Auth::guard('admin')->attempt(['email' => $requestData['email'], 'password' => $requestData['password']]))
        // return TRUE;

        // return FALSE;
    }
}
