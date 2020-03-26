<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Traits\phptraits;
class webServices extends Controller
{
	use phptraits;
    public function storeme(Request $request)
	{

		$validator=$this->authenticate($request);
		if($validator->fails()){
			return json_encode(["errors"=>$errors,"status"=>"fail|0"]);
		}
		else{
		$this->dataStore($request);
			
		return json_encode(['success'=>"Registration done Successfully"]);
		}
	}

	 public function checkme(Request $request){
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
