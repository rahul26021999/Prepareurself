<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['option','id','image','question_id'];

    public function Question()
    {
    	return $this->belongsTo('App\Models\Question');
    }
}
