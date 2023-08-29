<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

    public function logout(){
        Auth::logout();
        return redirect()->route('adminLogin');
    }
    public function postLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user_cred = $request->only('email', 'password');
        if (Auth::attempt($user_cred)) {
            if(Auth()->user()->id){
                return response()->json( ['message'=>'Login successful','url'=>route('adminUsers')] );
            }
        }else{
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

    }
}
