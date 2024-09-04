<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function show(){
        return view('auth.login');
    }

    public function login(Request $request){

        $attributes = request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if (Auth::attempt($attributes)) {

            session()->regenerate();
            $user = Auth::user();

            if ($user->role_type == 0) {
                // Admin
                return redirect('dashboard')->with(['success' => 'Welcome Admin, ' . $user->name . '!']);
            } elseif ($user->role_type == 1) {
                // Regular User
                return redirect('dashboard')->with(['success' => 'Welcome User, ' . $user->name . '!']);
            } else {
                // Unknown role, handle accordingly
                return redirect('dashboard')->with(['success' => 'Welcome, ' . $user->name . '!']);
            }
        } else {
            return back()->withErrors(['email' => 'Email or password invalid.']);
        }


    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }


}
