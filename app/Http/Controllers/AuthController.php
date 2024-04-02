<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(){
        return view('Auth.login');
    }

    public function handlelogin(Request $request){
        
        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }else {
            return redirect()-> back()->with('error_msg','paramètre de connexion non reconnue');
        }
    }
}
