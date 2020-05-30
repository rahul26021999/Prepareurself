<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = ['name','description','type','image_url','link','course_id','admin_id','playlist','level','status','sequence'];

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    public function ResourceProjectLikes()
    {
        return $this->hasMany('App\Models\ResourceProjectLikes','project_id');
    }
    public function ResourceProjectViews()
    {
        return $this->hasMany('App\Models\ResourceProjectViews','project_id');
    }
    public function ProjectRelatedLinks()
    {
        return $this->hasMany('App\Models\ProjectRelatedLinks','project_id');
    }
}
