<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenForumAttachment extends Model
{
    protected $fillable = ['id','query_id','reply_id','file'];

    public function OpenForumQuestion()
	{
		return $this->belongsTo('App\Models\OpenForumQuestion');
	}

	public function OpenForumAnswer()
	{
		return $this->belongsTo('App\Models\OpenForumAnswer');
	}
}
