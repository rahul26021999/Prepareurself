<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['id','type','body','subject','from','to','admin_id'];

    public function Admin()
    {
        return $this->belongsTo('App\Admin');
    }
}
