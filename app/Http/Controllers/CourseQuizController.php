<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Options;
use App\Models\UserCourseQuiz;
use App\Models\UserCourseQuizResponse;
use Exception;
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
   *     path="/api/save-course-quiz-response-single",
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
   *          name="quiz_id",
   *          in="query",
   *          description="Quiz id for a particular user and a particular course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="question_id",
   *          in="query",
   *          description="question id",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="answer_id",
   *          in="query",
   *          description="option id for correct answer",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
   public function saveCourseQuizResponseSingle(Request $request)
   {
      // include validator here 
      if($request->filled('quiz_id') && $request->filled('question_id') && $request->filled('answer_id'))
      {
         $update=UserCourseQuizResponse::where('quiz_id', $request['quiz_id'])
               ->where('user_id',JWTAuth::user()->id)
               ->where('question_id',$request['question_id'])
               ->update(['option_id' => $request['answer_id']]);

         if($update){
            return response()->json(['error_code'=>0,'message'=>"successfully saved answer for given question id"]);
         }else{
            return response()->json(['error_code'=>2,'message'=>"Not valid inputs"]);
         }

      }
      else{
         return response()->json(['error_code'=>1,'message'=>"Quiz id , question id and answer id can not be empty"]);
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
   *          name="quiz_id",
   *          in="query",
   *          description="Quiz id for a particular user and a particular course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *               type="array",
   *               @OA\Items(
   *                   type="object",
   *                   @OA\Property(type="integer", property="question_id", description="User name"),
   *                   @OA\Property(type="integer", property="answer_id", description="Education"),
   *               ),
   *             ),
   *          ),  
   *     ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */

   public function saveCourseQuizResponse(Request $request)
   {
      try
      {
         $score=0;
         $answers=json_decode($request->getContent());
         foreach ($answers as $index => $response) 
         {
            $update=UserCourseQuizResponse::where('quiz_id', $request['quiz_id'])
                  ->where('user_id',JWTAuth::user()->id)
                  ->where('question_id',$response->question_id)
                  ->update(['option_id'=>$response->answer_id]);

            if($update)
            {
               $answerModel=Answer::where('question_id',$response->question_id)->first();
               if($answerModel->option_id===$response->answer_id)
                  $score++;
            }
            else{
               return response()->json(['error_code'=>2,'message'=>"Not valid inputs"]);
            }
         }
         return response()->json([
            'error_code'=>0,
            'score'=>$score
         ]);
      }
      catch(Exception $e)
      {
         return response()->json([
            'error_code'=>1,
            'message'=>"Something Went wrong. Its an Exception".$e
         ]);
      }
   }
}
