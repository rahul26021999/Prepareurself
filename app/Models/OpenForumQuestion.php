<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumQuestion extends Model
{
    protected $fillable = ['id','course_id','user_id','query','image'];

    public function User()
    {
    	return $this->belongsTo('App\User');
    }

    public function Course()
    {
    	return $this->belongsTo('App\Models\Course');
    }

    public function OpenForumAnswer()
    {
    	return $this->hasMany('App\Models\OpenForumAnswer','query_id');
    }

    public function OpenForumAttachment()
    {
        return $this->hasMany('App\Models\OpenForumAttachment','query_id');
    }
}
