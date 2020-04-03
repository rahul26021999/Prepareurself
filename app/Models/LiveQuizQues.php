<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuizQues extends Model
{
    protected $fillable = ['ques_serial_no','question_id','live_quiz_id'];

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
    public function quiz()
    {
        return $this->belongsTo('App\Models\LiveQuiz');
    }
}
