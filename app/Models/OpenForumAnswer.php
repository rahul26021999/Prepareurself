<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumAnswer extends Model
{
	protected $fillable = ['id','query_id','user_id','reply'];

    public function OpenForumClap()
    {
    		return $this->hasMany('App\Models\OpenForumClap');
    }
}
