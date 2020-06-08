<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;
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
				'ques_level'=>$request['level'],
				'course_id'=>$request['course_id'],
				'admin_id'=>JWTAuth::user()->id,
			])->fresh();

			for ($i=1; $i<=4; $i++) 
			{ 
				if(isset($request['option'.$i]))
				{
					$option=Option::create([
						'option'=>$request['option'.$i],
						'question_id'=>$ques->id,
					]);

					if($request['answer']==$i)
					{ 
						Answer::create([
							'question_id'=>$ques->id,
							'option_id'=>$option->id
						]);
					}
				}
			}

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
			Question::find($id)
			->update([
				'question'=>$request['question'],
				'course_id'=>$request['course_id'],
				'ques_level'=>$request['level'],
				'admin_id'=>JWTAuth::user()->id
			]);

			$options=Option::where('question_id',$id)->get();
			foreach ($options as $i => $option) 
			{
				$i=$i+1;
				if(isset($request['option'.$i]))
				{
					$option->update([
						'option'=>$request['option'.$i],
					]);
					if($request['answer']==$i)
					{ 
						Answer::where(['question_id'=>$id])
						->update(['option_id'=>$option->id]);
					}
				}
			}
		}
		catch(Exception $e){
			Log::error("Error in saving question ".$e);   
			abort(404); 
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
