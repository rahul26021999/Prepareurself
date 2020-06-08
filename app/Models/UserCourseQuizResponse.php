<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseQuizResponse extends Model
{
    protected $fillable = ['user_id','quiz_id','id','option_id','question_id'];

    public function User()
    {
    	return $this->belongsTo('App\User');
    }

    public function UserCourseQuiz()
    {
    	return $this->belongsTo('App\Models\UserCourseQuiz');
    }

    public function Question()
    {
    	return $this->belongsTo('App\Models\Question');
    }

    public function Option()
    {
    	return $this->belongsTo('App\Models\Option');
    }
}
