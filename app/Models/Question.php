<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question','option1', 'option2', 'option3','option4','answer','ques_type','ques_level','course_id','admin_id'
    ];

    public function liveQuizQues()
    {
        return $this->hasMany('App\Models\LiveQuizQues');
    }

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
