<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Traits\UserAuthTrait;

class UserAuthController extends Controller
{
	use UserAuthTrait;

    public function register(Request $request)
	{

		$validator=$this->authenticateUserRegisteration($request);
		if($validator->fails()){
			return json_encode(["errors"=>$errors,"error_code"=>1,"success"=>false]);
		}
		else{
			$user=$this->saveUserData($request);			
			return json_encode(['success'=>true,"user_data"=>$user,"msg"=>"Registeration Successfully Done"]);
		}
	}

	public function login(Request $request){
	 	$email=request('email');
	 	$password=request('password');

	 	$post=User::where('email',$email)
	 				->where('password',$password)
	 				->first();
	 	if($post){
	 		Log::info('User Exist !!');  
	 		return json_encode(["status"=>"1"]);
	 	}
	 	else{
	 		return json_encode(["status"=>"0"]);
		
	 	}
	}
}
