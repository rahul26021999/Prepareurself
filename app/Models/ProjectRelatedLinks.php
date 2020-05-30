<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRelatedLinks extends Model
{
    protected $fillable = ['id','project_id','link','sequence'];

    public function Project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
