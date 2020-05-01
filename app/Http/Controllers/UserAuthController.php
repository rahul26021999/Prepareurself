<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Traits\UserAuthTrait;
use JWTAuth;
use Illuminate\Support\Carbon;

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
	 *          name="android_token",
	 *          in="query",
	 *          description="android token of user",
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
     *			description="{[error_code=>1,msg=>'Invalid user data'],[error_code=>0,msg=>'Registeration Successfully Done']}"
     *     )
     * )
     */
    public function register(Request $request)
	{

		$validator=$this->authenticateNewRegisterationRule($request);
		if($validator->fails()){			
			$errors=$validator->errors();
			return json_encode(["success"=>false,'error_code'=>1,"errors"=>$errors,"message"=>"Invalid user data"]);
		}
		else{
			$user=$this->saveUserData($request);
			$user->sendEmailVerificationMail();
			return response()->json([
	            'success' => true,
	            'error_code'=>0,	
	            'message'=>'User Registeration Successfully'            
	        ]);
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
     *			description="{[error_code=>2,msg=>'Username Already Exits'],[error_code=>0,msg=>'Username available'],[error_code=>1,msg=>'Missing user name']}"
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
	 *     @OA\Parameter(
	 *          name="android_token",
	 *          in="query",
	 *          description="android token of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error_code=>0,msg=>'login Successfully Done']}"
     *     )
     * )
     */
	public function login(Request $request)
	{
		if($request->filled('email') && $request->filled('password'))
		{
			$credentials = $request->only('email', 'password');
	        if (!$token = JWTAuth::attempt($credentials)) {
	            return response()->json([
	                'success' => false,
	                'error_code'=>3,
	                'message' => 'Invalid Email or Password'
	            ]);
	        }
	        $user=JWTAuth::user();
	        if(!$user->hasVerifiedEmail()){
	            $user->sendEmailVerificationMail();
	            return response()->json(['error'=>true,'error_code'=>2,'message'=>'Please Verify Your Email']);
	        }
	        if($request->filled('android_token')){
	        	$user->android_token=$request->input('android_token');
	        	$user->save();
	        }
	        return response()->json([
	            'success' => true,
	            'error_code'=>0,
	            'token' => $token,
	            'user' => $user
	        ]);
		}
		else{
			return json_encode(['success'=>false,'error_code'=>1,"message"=>'Missing email or password']);
		}
	}

	/**
     * @OA\Post(
     *     path="/api/update-user",
     *     tags={"User"},
     *     description="login a user to prepareurself",
	 *     @OA\Parameter(
	 *          name="token",
	 *          in="query",
	 *          description="token",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
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
	 *     @OA\Parameter(
	 *          name="profile_image",
	 *          in="query",
	 *          description="Profile image of the user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="file"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="preferences[]",
	 *          in="query",
	 *          description="User Preferences Please enter only integers",
	 *          required=false,
	 *          @OA\Schema(
	 *             	type="array",
	 *			     @OA\Items(type="integer"),
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error_code=>0,msg=>'Update Successfully Done']}"
     *     )
     * )
     */

	public function updateUserData(Request $request)
	{		
		$user=JWTAuth::user();
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
			$user->dob=Carbon::parse($request['dob']);
			if(isset($request['preferences[]']))
			{
				if(count($request['preferences'])==0){
					$user->preferences=null;
				}
				else{
					$user->preferences=implode(',',$request->input('preferences'));
				}
				
			}
			if($request->file('profile_image'))
	        {
	            $fileName = time().'.'.$request->file('profile_image')->extension();  
	            $request->file('profile_image')->move(public_path('uploads/users'), $fileName);
	            $user->profile_image=$fileName;
	        }    
			
			$user->save();
			return json_encode(['error_code'=>0,"user_data"=>$user,"msg"=>"update Successfully Done"]);
		}
		else{
			return json_encode(['error_code'=>2,"msg"=>'user does not exists']);	
		}
	}

	/**
     * @OA\Post(
     *     path="/api/update-password",
     *     tags={"User"},
     *     description="update a user password in prepareurself",
	 *     @OA\Parameter(
	 *          name="token",
	 *          in="query",
	 *          description="token",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="oldPassword",
	 *          in="query",
	 *          description="Old password of the user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="newPassword",
	 *          in="query",
	 *          description="New Password of the user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error_code=>0,msg=>'Successfully Password Changed']}"
     *     )
     * )
     */

	public function updatePassword(Request $request)
	{
		if(isset($request['oldPassword']) && isset($request['newPassword']))
		{
			$credentials=['email'=>JWTAuth::user()->email,'password'=>$request['oldPassword']];

			if (!$token = JWTAuth::attempt($credentials)) {
	            return response()->json([
		                'success' => false,
		                'error_code'=>2,
		                'message' => 'Invalid old Password',
	            	]);
	        }

			$validator=$this->newPasswordRule($request);
			if($validator->fails()){			
				$errors=$validator->errors();
				return response()->json(["success"=>false,'error_code'=>3,"errors"=>$errors,"message"=>"Invalid new Password"]);
			}
			else{
				$user = JWTAuth::user();
		        $user->password=Hash::make($request['newPassword']);
		        $user->save();
		        $user->sendPasswordUpdateMail();

		        return response()->json([
		        	'success' => true,
		            'error_code'=>0,
		            'token' => $token,
		           	'message'=>"Successfully Password Changed"
		        ]);
			}
		}
		else{
			return response()->json(['success'=>false,'error_code'=>1,"message"=>"Either Old password is missing or new Password is missing"]);
		}

	}

	/**
     * @OA\Post(
     *     path="/api/forget-password",
     *     tags={"User"},
     *     description="Send Forgot Password Mail to user in prepareurself",
	 *     @OA\Parameter(
	 *          name="email",
	 *          in="query",
	 *          description="Email of the user",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error_code=>0,msg=>'Forgot password Mail sent to your email']}"
     *     )
     * )
     */

	public function forgetPassword(Request $request)
	{
		if(isset($request['email']))
		{
			$user=User::where('email',$request['email'])->first();
			if($user==null){
				return response()->json(['success'=>false,'error_code'=>2,"message"=>"User Does not exists for this email"]);
			}
			else{
				$user->sendForgetPasswordMail();
				return response()->json(['success'=>true,'error_code'=>0,"message"=>"Forgot password Mail sent to your email"]);
			}
		}
		else{
			return response()->json(['success'=>false,'error_code'=>1,"message"=>"User Email is Missing"]);
		}
	}
}
