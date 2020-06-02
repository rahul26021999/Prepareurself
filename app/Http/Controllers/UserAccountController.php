<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserPreferences;
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



}
