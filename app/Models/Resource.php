<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JWTAuth;

class Resource extends Model
{
    protected $fillable = ['title','description','type','image_url','link','course_topic_id','admin_id'];

    protected $appends = ['total_likes','like','view','total_views'];


    public function getTotalViewsAttribute()
    {
        return $this->ResourceProjectViews()->count();
    }

    public function getViewAttribute($user_id)
    {
        return $this->ResourceProjectViews()->where('user_id',JWTAuth::user()->id)->count();
    }

    public function getTotalLikesAttribute()
    {
        return $this->ResourceProjectLikes()->count();
    }
    public function getLikeAttribute()
    {
        return $this->ResourceProjectLikes()->where('user_id',JWTAuth::user()->id)->count();
    }

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
