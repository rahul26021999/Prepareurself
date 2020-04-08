<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\User;
use Log;

class UserController extends Controller
{
    public function showAllUsers()
    {
    	$users=User::all();
		return view('backend.users.show',['users'=>$users]);
    }
}
