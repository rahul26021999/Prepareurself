<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','image_url','sequence'];

    // protected $appends = array('image');

    public function CourseTopic()
    {
        return $this->hasMany('App\Models\CourseTopic');
    }
    public function Resource()
    {
    	return $this->hasManyThrough('App\Models\Resource', 'App\Models\CourseTopic');
    }
    public function Project()
    {
        return $this->hasMany('App\Models\Projects');
    }
    
    // public function getImageAttribute()
    // {
    //     return url('/')."/uploads/courses/"."{$this->image_url}";
    // }
}
