<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function share($name='',$id='')
    {
    	return view('frontend.share.share');
    }
}
