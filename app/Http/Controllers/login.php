<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class login extends Controller
{
    public function index(Request $request)
    {
         if(!$request->session()->has('user_id')) {
            return view('forma_login',['auth'=> false]);
         }
         else
         {
            return redirect()->route('home');
         }
    }
    public function auth(Request $req)
    {
        $valid = $req->validate([
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|max:255'
        ]);

        $email = $req->input('email');
        $password = $req->input('password');

        $user = DB::table('owners')->where('email',$email)->first();

        if($user && Hash::check($password,$user->password))
        {
            $req -> session()->regenerateToken();
            $req -> session()->regenerate();

            $req->session()->put('user_id', $user->id);
            $req->session()->put('user_mail', $user->email);

            return redirect()->route('home');
        }
        else
        {
             return view('forma_login',['auth'=> true]);
        }

    }
}
