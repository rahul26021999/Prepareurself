<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceProjectLikes extends Model
{
     public function Resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
