<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function userLogin(){
        return view("login.login-page");
    }

    public function validateUserLogin(Request $request){
        // dd($request->all());
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            return redirect()->route('users.user-list')->with('success','User Login Successfully.');
        }

        return redirect()->back()->with('error','Invalid credentials. please try again.');
        
    }

    public function userLogout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success','User Logout Successfully.');
    }
}
