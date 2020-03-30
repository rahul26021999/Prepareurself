<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{

   public function showCreateQuestion()
   {
        return view('backend.questions.create');
   }
   public function saveQuestion(Request $request)
   {

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
