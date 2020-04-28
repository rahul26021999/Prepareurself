<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserFeedback extends Model
{
     protected $fillable = ['user_id','answer1','answer2','answer3','answer4','answer5','answer6'];
}
