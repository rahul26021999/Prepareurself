<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Traits\UserAuthTrait;

class UserAuthController extends Controller
{
	use UserAuthTrait;

	/**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"User"},
     *     description="Register a user to prepareurself",
	 *     @OA\Parameter(
	 *          name="first_name",
	 *          in="query",
	 *          description="first name of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="last_name",
	 *          in="query",
	 *          description="last name of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="password",
	 *          in="query",
	 *          description="Password of user Min length 8 characters",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="email",
	 *          in="query",
	 *          description="Email of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error=1,msg='Invalid user data'],[error=0,msg='Registeration Successfully Done']}"
     *     )
     * )
     */
    public function register(Request $request)
	{

		$validator=$this->authenticateNewRegisterationRule($request);
		if($validator->fails()){
			$errors=$validator->errors();
			return json_encode(["error_code"=>1,"errors"=>$errors,"msg"=>"Invalid user data"]);
		}
		else{
			$user=$this->saveUserData($request);			
			return json_encode(['error_code'=>0,"user_data"=>$user,"msg"=>"Registeration Successfully Done"]);
		}
	}
	/**
     * @OA\Post(
     *     path="/api/check-username",
     *     tags={"User"},
     *     description="Register a user to prepareurself",
	 *     @OA\Parameter(
	 *          name="username",
	 *          in="query",
	 *          description="check unique username of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *     ),
	 *     @OA\Response(
     *          response=200,
     *			description="{[error=>2,msg=>'Username Already Exits'],[error=>0,msg=>'Username available'],[error=>1,msg=>'Missing user name']}"
     *     )
     * )
     */
	public function checkUserName(Request $request)
	{
		$validator = $this->uniqueUserNameRule($request);
		if($validator->fails()){
			$errors=$validator->errors();
			return json_encode(['error_code'=>2,'errors'=>$errors,'msg'=>'Username Already Exits']);
		}
		else{
			return json_encode(['error_code'=>0,'msg'=>'Username available']);
		}
	}
	/**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"User"},
     *     description="login a user to prepareurself",
	 *     @OA\Parameter(
	 *          name="email",
	 *          in="query",
	 *          description="Email of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="password",
	 *          in="query",
	 *          description="password of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="login Successfully Done"
     *     )
     * )
     */
	public function login(Request $request)
	{
		if($request->filled('email') && $request->filled('password'))
		{
			$credentials = $request->only('email', 'password');
	        if (Auth::attempt($credentials)) {
	        	$user=User::where('email',$request['email'])->first();
	            return json_encode(['error_code'=>0,"user_data"=>$user,"msg"=>"login Successfully Done"]);
	        }
	        else{
				return json_encode(['error_code'=>2,"msg"=>'Invalid email or password']);
	        }
		}
		else{
			return json_encode(['error_code'=>1,"msg"=>'missing email or password']);
		}
	}

	/**
     * @OA\Post(
     *     path="/api/update-user",
     *     tags={"User"},
     *     description="login a user to prepareurself",
	 *     @OA\Parameter(
	 *          name="user_id",
	 *          in="query",
	 *          description="user id of user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="first_name",
	 *          in="query",
	 *          description="first name of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="last_name",
	 *          in="query",
	 *          description="last name of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="dob",
	 *          in="query",
	 *          description="date of birth of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="phone_number",
	 *          in="query",
	 *          description="user phone number",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="android_token",
	 *          in="query",
	 *          description="token for notification",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="update Successfully Done"
     *     )
     * )
     */

	public function updateUserData(Request $request)
	{
		if($request->filled('user_id'))
		{
			$user=User::find($request['user_id']);
			if($user!=null)
			{
				if($request->filled('first_name'))
				$user->first_name=$request->input('first_name');
				if($request->filled('last_name'))
				$user->last_name=$request->input('last_name');
				if($request->filled('phone_number'))
				$user->phone_number=$request->input('phone_number');
				if($request->filled('android_token'))
				$user->android_token=$request->input('android_token');
				if($request->filled('dob'))
				$user->dob=$request->input('dob');

				$user->save();
				return json_encode(['error_code'=>0,"user_data"=>$user,"msg"=>"update Successfully Done"]);

			}
			else{
				return json_encode(['error_code'=>2,"msg"=>'user does not exists']);	
			}
		}
		else{
			return json_encode(['error_code'=>1,"msg"=>'missing user id']);
		}
	}
}
