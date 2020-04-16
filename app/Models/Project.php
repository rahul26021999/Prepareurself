<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = ['name','description','type','image_url','link','course_id','admin_id','playlist'];

     public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
