<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseReviews extends Model
{

	protected $fillable = ['course_id','user_id','rating'];

	public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
