<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTopic extends Model
{
    protected $fillable = ['name','image_url','course_id'];

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    public function Resource()
    {
        return $this->hasMany('App\Models\Resource');
    }
}
