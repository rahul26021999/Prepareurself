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
          'answer'=>$request['answer'],
          'ques_level'=>$request['level'],
          'ques_type'=>$request['type']
        ]);
        if($request->filled('option3'))
          $ques->option3=$request['option3'];
        if($request->filled('option4'))
          $ques->option4=$request['option4'];

        $ques->save();
      }
      catch(Exception $e)
      {
          Log::error("Error in creating question ".$e);
      }
      return view('backend.questions.create');  
   }
   public function showEditQuestion($id)
   {
      $question=Question::find($id);
      $type=Question::distinct('ques_type')->pluck('ques_type')->toArray();
      return view('backend.questions.edit',['question'=>$question,'quesType'=>$type]);
   }
   public function showAllQuestion($type='all')
   {
      $question=Question::all();
      return view('backend.questions.show',['questions'=>$question]);
   }
}
