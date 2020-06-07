<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Question;
use JWTAuth;
use App\Models\Course;
use App\Exception;

class QuestionController extends Controller
{

   public function showCreateQuestion()
   {
        $courses=Course::get();
        return view('backend.questions.create',['courses' => $courses]);
   }
   public function createQuestion(Request $request)
   {
      try{
        $ques=Question::create([
          'question'=>$request['question'],
          'option1'=>$request['option1'],
          'option2'=>$request['option2'],
          'option3'=>$request['option3'],
          'option4'=>$request['option4'],
          'answer'=>$request['answer'],
          'ques_level'=>$request['level'],
          'course_id'=>$request['course_id'],
          'admin_id'=>JWTAuth::user()->id,
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating question ".$e);          
      }
      return redirect('/admin/question/all');  
   }
   public function showEditQuestion($id)
   {
      $question=Question::find($id);
      $courses=Course::get();
      return view('backend.questions.edit',['question'=>$question,'courses'=>$courses]);
   }
   public function saveEditQuestion(Request $request, $id)
   {
      try{
         $ques=Question::find($id);
         if($ques!=null)
         {
            $ques->question=$request['question'];
            $ques->answer=$request['answer'];
            $ques->course_id=$request['course_id'];
            $ques->ques_level=$request['level'];
            $ques->option1=$request['option1'];
            $ques->option2=$request['option2'];
            $ques->option3=$request['option3'];
            $ques->option4=$request['option4'];
            $ques->admin_id=JWTAuth::user()->id;
            $ques->save();
         }
         else{
            abort(404);
         }
      }
      catch(Exception $e){
        Log::error("Error in saving question ".$e);    
      }
      return redirect('admin/question/all');
   }
   public function showAllQuestion($type="")
   {
      if($type==""){
        $question=Question::all();
      }
      else{
        $question=Question::where('ques_level',$type)->get();
      }
      return view('backend.questions.show',['questions'=>$question]);
   }

    /**
   * @OA\Post(
   *     path="/api/get-quiz",
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

   public function getQuiz(Request $request)
   {
      $level=$request['level'];
      $course_id=$request['course_id'];
      $user=JWTAuth::user();
      
      // TODO:Excude previous attempted questions

      $questions=Question::where(['course_id'=>$course_id,'ques_level'=>$level])->inRandomOrder()->limit(10)->get();

      return response()->json([
        'error_code'=>0,
        'questions'=>$questions
      ]);
   }
}
