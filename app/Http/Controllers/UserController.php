<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\User;
use Log;

class UserController extends Controller
{
    public function showAllUsers($type='')
    {
    	if($type=='blocked'){
    		$users=User::where('user_status','blocked')->get();
    	}
    	else{
    		$users=User::all();
    	}
		return view('backend.users.show',['users'=>$users]);
    }
}
