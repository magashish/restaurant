<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    //
    public function getUsers()
    {
        $users = User::orderBy('created_at','desc')->paginate(15);
        return view('pages.admin.users.index',compact('users'));
    }

    public function deleteUsers(Request $request,$id)
    {
       
        DB::table('users')->where('id',$id)->delete();
        return redirect()->back()->with('success','User Deleted Successfully');

    }

    public function userDetails($id)
    {
        dd($id);
    }
}
