<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceProjectLikes extends Model
{
	protected $fillable = [
        'user_id','project_id','resource_id'
    ];

    public function Resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
