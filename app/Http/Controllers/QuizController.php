<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveQuiz;
use App\Models\LiveQuizQues;
use App\Models\Question;
use Log;

class QuizController extends Controller
{
   public function showCreateQuiz()
   {
      $questions=Question::with('LiveQuizQues')->get()->toArray();
      // Log::info();
      // echo '<pre>';
      // return json_encode($questions);
      // echo '</pre>';
      return view('backend.quizes.create',['questions'=>$questions]);
   }
   public function createQuiz(Request $request)
   {
      try{
        $quiz=LiveQuiz::create([
          'quiz_title'=>$request['title'],
          'quiz_desc'=>$request['description'],
          'no_of_ques'=>$request['noOfQues'],
          'ques_time_span'=>$request['timeSpan'],
          'start_time'=>$request['quizTime'],
        ]);
        for($i=1;$i<=$quiz['no_of_ques'];$i++)
        {
            LiveQuizQues::create([
              'ques_serial_no'=>$i,
              'question_id'=>$request['quizQues'][$i-1],
              'live_quiz_id'=>$quiz->id,
            ]);
        }
      }
      catch(Exception $e){
          Log::error("Error in creating question ".$e);          
      }
      return redirect('/admin/quiz/all');  
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
      $quiz=LiveQuiz::all();
      return view('backend.quizes.show',['quizzes'=>$quiz]);
   }
}
