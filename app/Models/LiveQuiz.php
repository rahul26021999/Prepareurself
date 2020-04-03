<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuiz extends Model
{
    //
    protected $fillable = ['quiz_title','quiz_desc','no_of_ques','start_time','ques_time_span'];
          
    public function question()
    {
        return $this->hasMany('App\Models\LiveQuizQues');
    }
}
