<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumAnswer extends Model
{
	protected $fillable = ['id','query_id','user_id','reply'];

	public function OpenForumQuestion()
	{
		return $this->belongsTo('App\Models\OpenForumQuestion');
	}

	public function User()
    {
    	return $this->belongsTo('App\User');
    }

    public function OpenForumClap()
    {
    	return $this->hasMany('App\Models\OpenForumClap','reply_id');
    }

    public function OpenForumAttachment()
    {
        return $this->hasMany('App\Models\OpenForumAttachment','reply_id');
    }
}
