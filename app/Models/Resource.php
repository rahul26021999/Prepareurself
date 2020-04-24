<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['title','description','type','image_url','link','course_topic_id','admin_id'];

    public function CourseTopic()
    {
        return $this->belongsTo('App\Models\CourseTopic');
    }
    public function ResourceProjectLikes()
    {
        return $this->hasMany('App\Models\ResourceProjectLikes','resource_id');
    }
    public function ResourceProjectViews()
    {
        return $this->hasMany('App\Models\ResourceProjectViews','resource_id');
    }
}
