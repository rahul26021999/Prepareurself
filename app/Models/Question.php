<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question','ques_level','course_id','admin_id'
    ];


    public function Admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function Option()
    {
        return $this->hasMany('App\Models\Option');
    }

    public function UserCourseQuizResponse()
    {
        return $this->hasMany('App\Models\UserCourseQuizResponse');
    }

    public function Answer()
    {
        return $this->hasOne('App\Models\Answer');
    }

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
