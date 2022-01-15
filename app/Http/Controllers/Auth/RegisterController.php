<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) 
    {
     
        $user = new User();
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->ip_address = $request->ip();
        $user->save();

        auth()->login($user);

        $notification = array(
            'message' => 'Account successfully registered.',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);
    }
}
