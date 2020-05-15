<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Exception;

trait UserAuthTrait {

	public function authenticateNewRegisterationRule(Request $request)
	{
		return Validator::make($request->all(), [
			'first_name' => 'required',
			'password' => 'required|min:8',
			'email' => 'required|email:rfc,dns|unique:users',
		]); 	
	}
	public function newPasswordRule(Request $request)
	{
		return Validator::make($request->all(), [
			'newPassword' => 'required|min:8',
		]);	
	}
	public function uniqueUserNameRule(Request $request)
	{
		return $validator = Validator::make($request->all(), [
			'username' => 'required|unique:users'
		]);
	}
	public function registerNewUser(Request $request)
	{
		try{
			$user=User::create([
				'email'=>$request['email'],
				'android_token'=>$request->input('android_token',null),
				'first_name'=>$request['first_name'],
				'last_name'=>$request->input('last_name',null),
				'phone_number'=>$request->input('phone_number',null),
				'dob'=>$request->input('dob',null),
				'android_token'=>$request->input('dob',null),
				'profile_image'=>$request->input('profile_image',null),
				'google_id'=>$request->input('google_id',null),
				'password'=>Hash::make($request->input('password',null)),
			])->fresh();
			
			return $user;
		}
		catch(Exception $e)
		{
			Log::alert("UserAuthTrait:saveUserData ".$e->message());
		}  
	}

}