<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model
{
    protected $fillable = ['id','course_id','user_id'];

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
