<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Traits\UserAuthTrait;
use App\Traits\SuggestedCourseTrait;
use JWTAuth;
use Illuminate\Support\Carbon;
use App\Models\Course;
use App\Models\Resource;
use App\Models\CourseTopic;
use App\Models\Project;

class UserAuthController extends Controller
{
	use UserAuthTrait;
	use SuggestedCourseTrait;

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
			$user=$this->registerNewUser($request);
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
     *     path="/api/social-register",
     *     tags={"User"},
     *     description="Register a user to prepareurself through google",
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
	 *          name="google_id",
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
	 *     @OA\Parameter(
	 *          name="phone_number",
	 *          in="query",
	 *          description="phone_number of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="dob",
	 *          in="query",
	 *          description="dob of user",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="profile_image",
	 *          in="query",
	 *          description="profile_image of user",
	 *          required=false,
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

	public function socialRegisterLogin(Request $request)
	{
		$user=User::where('email',$request['email'])->first();
		if($user==null){
			$user=$this->registerNewUser($request);
		}
		else{
			$user->first_name=$request->input('first_name',$user->first_name);
			$user->last_name=$request->input('last_name',$user->last_name);
			$user->phone_number=$request->input('phone_number',$user->phone_number);
			$user->dob=$request->input('dob',$user->dob);
			$user->android_token=$request->input('android_token',$user->android_token);
			$user->profile_image=$request->input('profile_image',$user->profile_image);
			$user->google_id=$request->input('google_id',$user->google_id);
			$user->save();
			$user->refresh();
		}

		$token = JWTAuth::fromUser($user);
		return response()->json([
			'success' => true,
			'error_code'=>0,
			'token' => $token,
			'user' => $user
		]);
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

			if(isset($request['last_name'])){
				if($request['last_name']=='')
					$user->last_name=null;
				else
					$user->last_name=$request->input('last_name');
			}

			if(isset($request['phone_number'])){
				if($request['phone_number']=='')
					$user->phone_number=null;
				else
					$user->phone_number=$request->input('phone_number');
			}

			if($request->filled('android_token'))
				$user->android_token=$request->input('android_token');
			
			if(isset($request['dob'])){
				if($request['dob']=='')
					$user->dob=null;
				else
					$user->dob=Carbon::parse($request['dob']);
			}	

			if(isset($request['preferences']))
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
     *     path="/api/resend-verification-mail",
     *     tags={"User"},
     *     description="resend verification mail if not received in prepareurself",
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
     *			description="{[error_code=>0,msg=>'resend mail Successfully Done']}"
     *     )
     * )
     */
public function wsResendVerificationMail(Request $request)
{
	if($request->filled('email'))
	{
		$user=User::where('email',$request['email'])->first();
		if($user!=null)
		{
			if(!$user->hasVerifiedEmail()){
				$user->sendEmailVerificationMail();
				return response()->json(['error'=>false,'error_code'=>0,'message'=>'We have sent you verification Email again Please check']);
			}
			else{
				return response()->json(['error'=>false,'error_code'=>0,'message'=>'User is Already Verified Please login']);
			}

		}else{
			return response()->json(['error'=>true,'error_code'=>2,'message'=>'User does not exists']);
		}
	}
	else{
		return response()->json(['error'=>true,'error_code'=>1,'message'=>'Email is required']);
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


	/**
   * @OA\Post(
   *     path="/api/get-home-page",
   *     tags={"HomePage"},
   *     description="Get all home page data",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
	public function wsGetHomePage(Request $request){

		$user=JWTAuth::user();
		if($user!=null){

			$result=array();



			# for latest 5 courses as per sequence
			$course=Course::where('status','publish')->orderBy('sequence','asc')->take(5)->get();

			$courseArray = array(
				'title' => 'Tech - Stack',
				'type'	=>	'course',
				'seeAll'=>  true,
				'courses' => $course
			);
			array_push($result, $courseArray);


			#Trending Projects
			$project=Project::withCount('ResourceProjectViews as total_views')
			->withCount('ResourceProjectLikes as total_likes')	
			->where('status','publish')
			->orderBy('total_views','DESC')
			->take(10)->get();

			$projectArray = array(
				'title' => 'Trending Projects',
				'seeAll' => false,
				'views'=>true,
				'likes'=>true,
				'postedOn'=>false,
				'type'	=>	'project',
				'project' => $project
			);

			array_push($result, $projectArray);
		//	array_push($result, ["type"=>"ads"]);


			#Newly Mix Resources

			$resources=Resource::whereHas('CourseTopic', function ($query) {
				$query->where('status', 'publish');
			})->orderBy('created_at','DESC')
			->take(10)->get();

			$resourceArray = array(
				'title' => 'New Resources',
				'seeAll' => false,
				'postedOn'=>true,
				'views'=>true,
				'likes'=>false,
				'type'	=>	'resource',
				'resource' => $resources
			);

			array_push($result, $resourceArray);
		//	array_push($result, ["type"=>"ads"]);

			# for suggested topics
			$topic_course_id=$this->getSuggestedTopicCourse($request);
			$topic_course=Course::find($topic_course_id);
			$topic=CourseTopic::where('course_id',$topic_course_id)->where('status','publish')->orderBy('sequence','asc')->take(5)->get();

			$topicArray = array(
				'title' => 'Topics you may like',
				'type'	=>	'topic',
				'seeAll' => true,
				'course'=> $topic_course,
				'topics' => $topic
			);
			array_push($result, $topicArray);

      		# for suggested projects
			$project_course_id=$this->getSuggestedProjectCourse($request);
			$project_course=Course::find($project_course_id);
			$project=Project::where('course_id',$project_course_id)
			->where('status','publish')
			->orderBy('sequence','asc')
			->take(5)->get();
			
			$projectArray = array(
				'title' => 'Recommended Projects',
				'seeAll' => true,
				'type'	=>	'project',
				'postedOn'=>false,
				'views'=>false,
				'likes'=>false,
				'course'=> $project_course,
				'project' => $project
			);
			array_push($result, $projectArray);
			array_push($result, ["type"=>"ads"]);
			return response()->json(['success'=>true,'error_code'=>0,"message"=>"success",'data'=>$result]);

		}
		else{
			return response()->json(['success'=>false,'error_code'=>1,"message"=>"User not valid"]);
		}

	}


	/**
   * @OA\Post(
   *     path="/api/user",
   *     tags={"User"},
   *     description="Get User details",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
	public function getUser(Request $request)
	{
		$user=JWTAuth::user();
		if($user!=null){
			return response()->json([
				'success'=>true,
				'error_code'=>0,
				'user'=>$user
			]);
		}else{
			return response()->json([
				'success'=>false,
				'error_code'=>1
			]);
		}
	}
}
