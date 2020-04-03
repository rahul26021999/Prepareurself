<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveQuiz extends Model
{
    //
    protected $fillable = ['quiz_title','quiz_desc','no_of_ques','start_time','ques_time_span'];
          
}
