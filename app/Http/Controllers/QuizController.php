<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveQuiz;
use App\Models\Question;
use Log;

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
          'quiz_title'=>$request['title'],
          'quiz_desc'=>$request['description'],
          'no_of_ques'=>$request['noOfQues'],
          'start_time'=>$request['timeSpan'],
          'ques_time_span'=>$request['quizTime'],
        ]);
        // for($i=0;$i<$quiz['no_of_ques'];$i++)
        // {
        //     $request['quizQues'][$i];
        // }
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
