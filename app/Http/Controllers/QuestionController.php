<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class QuestionController extends Controller
{

   public function showCreateQuestion()
   {
        return view('backend.questions.create');
   }
   public function saveQuestion(Request $request)
   {
      Log::info($request);
      return view('backend.questions.create');  
   }
   public function showEditQuestion($id)
   {
        return view('backend.questions.edit');
   }
   public function showAllQuestion($type='all')
   {
        return view('backend.questions.show');
   }
}
