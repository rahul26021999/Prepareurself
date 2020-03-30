<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function showCreateQuiz()
   {
        return view('backend.quizes.create');
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
