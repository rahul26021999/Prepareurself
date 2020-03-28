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
 
    public function authenticateNewRegisteration(Request $request)
	{
		return Validator::make($request->all(), [
			'first_name' => 'required',
			'username' => 'required|unique:users',
			'password' => 'required|min:8|',
            'email' => 'required|email:rfc,dns|unique:users',
		]); 	
	}
	public function uniqueUserNameRule(Request $request)
	{
		return $validator = Validator::make($request->all(), [
			'username' => 'required|unique:users'
		]);
	}
	public function saveUserData(Request $request)
	{
		try{
			$user=User::create([
				'email'=>$request['email'],
				'first_name'=>$request['first_name'],
				'last_name'=>$request->input('last_name',''),
				'username'=>$request['username'],
				'password'=>Hash::make($request['password']),
			]);
			return $user;
		}
		catch(Exception $e)
		{
			Log::alert("UserAuthTrait:saveUserData ".$e->message());
		}  
	}
 
}