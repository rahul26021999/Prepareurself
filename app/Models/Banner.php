<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title','image','status'];

    protected $appends = array('image_url');

    public function getImageUrlAttribute()
    {
        return url('/')."/uploads/banners/"."{$this->image}";
    }
}
