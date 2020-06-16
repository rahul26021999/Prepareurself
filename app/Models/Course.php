<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','image_url','sequence','description','logo','color'];

    protected $appends = ['logo_url','average_rating'];
    
    protected $hidden = ['logo'];

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
    public function Question()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function CourseReviews()
    {
        return $this->hasMany('App\Models\CourseReviews');
    }

    public function UserPreferences()
    {
        return $this->hasMany('App\Models\UserPreferences');
    }
    public function getLogoUrlAttribute()
    {
        if($this->logo!=null)
            return url('/')."/uploads/courses/logos/".$this->logo;
        else
            return null;
    }

    public function getAverageRatingAttribute()
    {
	return $this->CourseReviews()->avg('rating')?:0;
    }
}
