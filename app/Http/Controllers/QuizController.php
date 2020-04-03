<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveQuiz;

class QuizController extends Controller
{
   public function showCreateQuiz()
   {
      $questions=Question::all();
      return view('backend.quizes.create',['questions'=>$questions]);
   }
   public function createQuiz(Request $request)
   {
      try{
        $quiz=LiveQuiz::create([
          'quiz_title'=>$request['question'],
          'quiz_desc'=>$request['option1'],
          'no_of_ques'=>$request['option2'],
          'start_time'=>$request['answer'],
          'ques_time_span'=>$request['level'],
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating question ".$e);          
      }
      return view('backend.questions.create');  
   }

   public function saveQuiz(Request $request)
   {

   }
   public function showEditQuiz($id)
   {
        return view('backend.quizes.edit');
   }
   public function showAllQuiz($type='all')
   {
        return view('backend.quizes.show');
   }
}
