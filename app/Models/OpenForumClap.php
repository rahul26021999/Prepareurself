<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumClap extends Model
{
    protected $fillable = ['id','user_id','reply_id'];

   public function OpenForumAnswer()
   {
    	return $this->belongsTo('App\Models\OpenForumAnswer');
   }
   
   public function User()
   {
    	return $this->belongsTo('App\User');
   }
}
