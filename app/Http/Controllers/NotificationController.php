<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class NotificationController extends Controller
{
    public function ray(){
    	$user=User::where('email','rahul26021999@gmail.com')->first();
    	$user->sendAndroidNotification();
    }
}
