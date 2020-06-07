<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserPreferences;
use App\Models\CourseReviews;
use JWTAuth;

class UserAccountController extends Controller
{


	/**
     * @OA\Post(
     *     path="/api/update-user-preferences",
     *     tags={"User"},
     *     description="Update user preferences",
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
     *			description="{[error_code=>0,msg=>'Update preferences Successfully Done']}"
     *     )
     * )
     */
    public function updateUserPreferences(Request $request)
    {
    	$user=JWTAuth::user();

    	if(isset($request['preferences']))
    	{
    		UserPreferences::where('user_id',$user->id)->delete();
    		foreach ($request['preferences'] as $value) {
    			UserPreferences::create([
    				'user_id'=>$user->id,
    				'course_id'=>$value
    			]);
    		}
    		return response()->json([
    			'error_code'=>0,
    			"message"=>'Successfully udpate User Prefrences'
    		]);
    	}
    	else{
    		UserPreferences::where('user_id',$user->id)->delete();
    		return response()->json([
    			'error_code'=>0,
    			'message'=>"User Prefrences Removed Successfully"
    		]);
    	}
    }


	/**
     * @OA\Post(
     *     path="/api/rate-course",
     *     tags={"Courses"},
     *     description="Rate Course by user or update rating on course by user",
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
	 *          name="course_id",
	 *          in="query",
	 *          description="User Preferences Please enter only integers",
	 *          required=true,
	 *          @OA\Schema(
	 *             	type="integer",
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="rating",
	 *          in="query",
	 *          description="rating on course Only intergers allowed 1,2,3,4,5",
	 *          required=true,
	 *          @OA\Schema(
	 *             	type="integer",
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[error_code=>0,msg=>'Thanks for rating']}"
     *     )
     * )
     */

    public function rateCourse(Request $request){

    	if(isset($request['course_id']) && isset($request['rating']))
    	{
    		CourseReviews::updateOrCreate([   
    			'user_id'=>JWTAuth::user()->id,
    			'course_id'=>$request['course_id'] 
    		],[
    			'rating'=>$request['rating']
    		]);

	    	return response()->json([
	    		'error_code'=>0,
	    		'message'=>"Thank you for Rating"
	    	]);	
    	}
    	else{
    		return response()->json([
    			'error_code'=>1,
    			'message'=>"Either course id missing or rating missing"
    		]);
    	}
    	
    }

    /**
     * @OA\Post(
     *     path="/api/add-to-user-preferences",
     *     tags={"User"},
     *     description="Add Course to user preferences",
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
     *          name="course_id",
     *          in="query",
     *          description="Course id for the preference",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",     
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="type",
     *          in="query",
     *          description="type: 1 to add and 0 to remove ",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="{[error_code=>0,msg=>'Update preferences Successfully Done']}"
     *     )
     * )
     */
    public function addToUserPreferences(Request $request)
    {
        $user=JWTAuth::user();
        if($request->filled('course_id'))
        {
            if($request['type']=='1')
            {
                UserPreferences::updateOrCreate([
                    'user_id'=>$user->id,
                    'course_id'=>$request['course_id']
                ]);
                return response()->json([
                    'error_code'=>0,
                    "message"=>'Successfully added to User Prefrences'
                ]);
            }
            else
            {
                UserPreferences::where(['user_id'=>$user->id,'course_id'=>$request['course_id']])->delete();
                return response()->json([
                    'error_code'=>0,
                    "message"=>'Successfully removed from User Prefrences'
                ]);
            }
        }
        else{
            return response()->json([
                'error_code'=>1,
                'message'=>"Course id is compulsory"
            ]);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/get-user-preferences",
     *     tags={"User"},
     *     description="get user preferences",
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
     *          description="{[error_code=>0,msg=>'Update preferences Successfully Done']}"
     *     )
     * )
     */
    public function listUserPreferences(Request $request)
    {
        $user_preferences=UserPreferences::where('user_id',JWTAuth::user()->id)->get();
        return response()->json([
            'error_code'=>0,
            'user_preferences'=>$user_preferences
        ]);
    }

}
