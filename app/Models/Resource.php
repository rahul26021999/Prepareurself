<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['title','description','type','image_url','link','course_topic_id'];

    public function CourseTopic()
    {
        return $this->belongsTo('App\Models\CourseTopic');
    }
}
