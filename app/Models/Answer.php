<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['id','ques_id','option_id'];

    public function Question()
    {
    	$this->belongsTo('App\Models\Question');
    }

    public function Option()
    {
    	$this->belongsTo('App\Models\Option');
    }
}
