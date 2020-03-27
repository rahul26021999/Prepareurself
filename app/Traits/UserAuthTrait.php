<?php
 
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Exception;
 
trait phptraits {
 
    public function authenticateUserRegisteration($request)
	{
		
		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'required',
			'phone_number' => 'required|size:10',
			'password' => 'required| min:8|unique:users',
            'email' => 'required|email:rfc,dns|unique:users',

		]);
		return $validator;  	
	}
	public function saveUserData($request)
	{
		try{
			$user=User::create([
				'email'=>request('email'),
				'android_token'=>request('android_token'),
				'first_name'=>request('first_name'),
				'last_name'=>request('last_name'),
				'username'=>request('username'),
				'phone_number'=>request('phone_number'),
				'password'=>request('password'),
			]);	
			return $user;
		}
		catch(Exception $e)
		{

		}  
	}
 
}