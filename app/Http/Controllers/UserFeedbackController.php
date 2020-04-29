<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\UserFeedback;
use App\Traits\UserAuthTrait;
use Session;
use JWTAuth;
use Log;
use Auth;
use App\User;

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
   *          name="answers[]",
   *          in="query",
   *          description="User Preferences Please enter only String",
   *          required=true,
   *          @OA\Schema(
   *                type="array",
   *            @OA\Items(type="string"),
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
	 
      if( $request->filled('answers') && count($request['answers']) == 6)
      {
         UserFeedback::create([
            'user_id'=>JWTAuth::user()->id,
            'answer1'=>$request['answers'][0],
            'answer2'=>$request['answers'][1],
            'answer3'=>$request['answers'][2],
            'answer4'=>$request['answers'][3],
            'answer5'=>$request['answers'][4],
            'answer6'=>$request['answers'][5]
         ]);
         $user=JWTAuth::user();
         $user->sendUserFeedbackMail();
         return response()->json(['error_code'=>0,'message'=>'success']);

      }
      else{
         return response()->json(['error_code'=>1,'message'=>'failure']);
      }
	 	
	 }//end of function


}// end of class

