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
}
