<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseQuiz extends Model
{
    protected $fillable = ['user_id','id','course_id','status'];

    public function User()
    {
    	return $this->belongsTo('App\User');
    }

    public function Course()
    {
    	return $this->belongsTo('App\Models\Course');
    }

    public function UserCourseQuizResponse()
    {
        return $this->hasMany('App\Models\UserCourseQuizResponse','quiz_id');
    }

}
