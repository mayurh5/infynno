<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function perform()
    {
        Session::flush();
        
        Auth::logout();
        
        $notification = array(
            'message' => 'ThankYou for using this web-app.!',
            'alert-type' => 'success'
        );

        return redirect('login')->with($notification);
    }
}
