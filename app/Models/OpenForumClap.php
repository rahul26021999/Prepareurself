<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumClap extends Model
{
    protected $fillable = ['id','user_id','open_forum_id'];

   public function OpenForum()
   {
    		return $this->belongsTo('App\Models\OpenForum');
   }
   
   public function User()
   {
    		return $this->belongsTo('App\User');
   }
}
