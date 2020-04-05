<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','image_url'];

    public function CourseTopic()
    {
        return $this->hasMany('App\Models\CourseTopic');
    }

}
