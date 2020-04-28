<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserFeedback extends Model
{
     protected $fillable = ['user_id','question1','question2','question3','question4','question5'];
}
