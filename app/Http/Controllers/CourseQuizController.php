<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Question;
use App\Models\Options;
use App\Models\UserCourseQuiz;
use App\Models\UserCourseQuizResponse;
use JWTAuth;
use Log;

class CourseQuizController extends Controller
{
   
    /**
   * @OA\Post(
   *     path="/api/get-course-quiz",
   *     tags={"Quiz"},
   *     description="Get a Quiz for a particular user for a particular course",
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
   *          description="Course id for a particular course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="level",
   *          in="query",
   *          description="easy|medium|hard",
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

   public function getCourseQuiz(Request $request)
   {
      $level=$request['level'];
      $course_id=$request['course_id'];
      $user=JWTAuth::user();
      
      $AttemptedQuestions=UserCourseQuizResponse::where('user_id',$user->id)
                           ->where('option_id','!=',null)
                           ->pluck('question_id')->toArray();
      
      $questions=Question::where(['course_id'=>$course_id,'ques_level'=>$level])
                           ->with('Option')
                           ->with('Answer')
                           ->whereNotIn('id',$AttemptedQuestions)
                           ->inRandomOrder()->limit(10)->get();

      if(count($questions)>0)
      {
         $quiz=UserCourseQuiz::create([
            'user_id'=>$user->id,
            'course_id'=>$course_id,
         ])->fresh();

         $quiz['questions']=$questions;   
         foreach ($questions as $i => $question) 
         {
            UserCourseQuizResponse::create([
               'quiz_id'=>$quiz->id,
               'user_id'=>$user->id,
               'question_id'=>$question->id,
               'option_id'=>null,
            ])->fresh();
         }
         return response()->json([
            'error_code'=>0,
            'quiz'=>$quiz,
         ]);
      }
      else
      {
         return response()->json([
            'error_code'=>1,
            'message'=>'Out Of attempt'
         ]);
      }
   }

   /**
   * @OA\Post(
   *     path="/api/save-course-quiz-response",
   *     tags={"Quiz"},
   *     description="save a Quiz Response for a particular user for a particular course",
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
   *          description="Course id for a particular course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="level",
   *          in="query",
   *          description="easy|medium|hard",
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

   public function saveCourseQuizResponse(Request $request)
   {
      
   }
}
