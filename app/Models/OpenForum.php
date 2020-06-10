<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForum extends Model
{
    protected $fillable = ['id','course_id','user_id','parent_id','image','query'];

    public function OpenForumClap()
    {
    		return $this->hasMany('App\Models\OpenForumClap');
    }

    public function User()
    {
    		return $this->belongsTo('App\User');
    }

    public function Course()
    {
    		return $this->belongsTo('App\Models\Course');
    }

    public function OpenForum()
    {
    		return $this->belongsTo('App\Models\OpenForum');
    }
}
