<?php
 
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\User;
 
trait phptraits {
 
    public function authenticate($request)
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
	public function dataStore($request)
	{
		User::create([
			'email'=>request('email'),
			'android_token'=>request('android_token'),
			'first_name'=>request('first_name'),
			'last_name'=>request('last_name'),
			'username'=>request('username'),
			'phone_number'=>request('phone_number'),
			'password'=>request('password'),
		]);
		 try{
                // Mail::to($request['email'])->send(new WelcomeMail());
                Log::info('EMAIL SENT !!');  
            }
            catch(\Exception $e)
            {
                log::info($e);
            } 
		   

	}
 
}