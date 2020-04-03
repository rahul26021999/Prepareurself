<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Question;
use App\Exception;

class QuestionController extends Controller
{

   public function showCreateQuestion()
   {
        $type=Question::distinct('ques_type')->pluck('ques_type')->toArray();
        return view('backend.questions.create',['quesType' => $type]);
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
          'ques_type'=>$request['type']
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
      $type=Question::distinct('ques_type')->pluck('ques_type')->toArray();
      return view('backend.questions.edit',['question'=>$question,'quesType'=>$type]);
   }
   public function saveEditQuestion(Request $request, $id)
   {
      try{
         $ques=Question::find($id);
         if($ques!=null)
         {
            $ques->question=$request['question'];
            $ques->answer=$request['answer'];
            $ques->ques_type=$request['type'];
            $ques->ques_level=$request['level'];
            $ques->option1=$request['option1'];
            $ques->option2=$request['option2'];
            $ques->option3=$request['option3'];
            $ques->option4=$request['option4'];
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
   public function showAllQuestion($type='all')
   {
      $question=Question::all();
      return view('backend.questions.show',['questions'=>$question]);
   }
}
