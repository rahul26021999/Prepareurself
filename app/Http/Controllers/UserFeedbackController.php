<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\UserFeedback;
use Session;
use JWTAuth;
use Log;
use Auth;

class UserFeedbackController extends Controller
{

	 /**
   * @OA\Post(
   *     path="/api/store-feedback",
   *     tags={"User Feedback"},
   *     description="Store Feedback of a user",
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
   *          name="question1",
   *          in="query",
   *          description="Type of response: Very Good|Good|Fair|Bad",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="question2",
   *          in="query",
   *          description="Type of response: Very Good|Good|Fair|Bad",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="question3",
   *          in="query",
   *          description="Type of response: Very Good|Good|Fair|Bad",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="question4",
   *          in="query",
   *          description="Type of response: Very Good|Good|Fair|Bad",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="question5",
   *          in="query",
   *          description="Type of response: String value",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Response(
     *          response=200,
     *      description="{[error_code=>0,msg=>'success'],[error_code=>1,msg=>'failure']}"
     *     )
     * )
     */


	 public function storeFeedback(Request $request)
	 {        
	 	$question1=$request->input('question1',null);
	 	$question2=$request->input('question2',null);
	 	$question3=$request->input('question3',null);
	 	$question4=$request->input('question4',null);
	 	$question5=$request->input('question5',null);
	 	if($question1!=null && $question2!=null && $question3!=null && $question4!=null && $question5!=null )
	 	{
			UserFeedback::create([
 			'user_id'=>JWTAuth::user()->id,
 			'question1'=>$question1,
 			'question2'=>$question2,
 			'question3'=>$question3,
 			'question4'=>$question4,
 			'question5'=>$question5,

 			]);
 			return response()->json(['error_code'=>0,'msg'=>'success']);
	 	}
	 	else{
	 		 return response()->json(['error_code'=>1,'msg'=>'failure']);
	 	}
	 }//end of function


}// end of class

