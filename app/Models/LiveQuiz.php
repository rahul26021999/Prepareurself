<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuiz extends Model
{
    //
    protected $fillable = ['quiz_title','quiz_desc','no_of_ques','start_time','ques_time_span'];
          
    public function liveQuizQues()
    {
        return $this->hasMany('App\Models\LiveQuizQues');
    }
    public function question() 
    {
    	return $this->hasManyThrough('App\Models\Question' , 'App\Models\LiveQuizQues');
	}

}
