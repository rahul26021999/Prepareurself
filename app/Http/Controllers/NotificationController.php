<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class NotificationController extends Controller
{
    public function ray(Request $request;){
    	$user=User::where('email',$request['email'])->first();
    	$user->sendAndroidNotification();
    }
}
