<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    //

    public function show(){
        return view('auth.register');
    }

    public function register(){

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );
        $attributes['role_type'] = 1;
        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        // Auth::login($user);
        return redirect('/login');

    }

}
