<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Resource;
use App\Models\Course;

class ShareController extends Controller
{
    public function share()
    {
    	return view('frontend.share.app',['type'=>'home']);
    }
    public function shareResource($id)
    {
    	$resource_id=base64_decode($id);
    	$resource=Resource::find($resource_id);
    	if($resource!=null)
    		return view('frontend.share.app',['id'=>$resource_id,'type'=>$resource->type]);
    	else
    	   return view('frontend.share.app');
    }
    public function shareProject($id)
    {
    	$project_id=base64_decode($id);
    	$project=Project::find($project_id);
    	if($project!=null)
    		return view('frontend.share.app',['id'=>$project_id,'type'=>'project']);
    	else
    	   return view('frontend.share.app',['type'=>'home']);
    	
    }
    public function shareCourse($id)
    {

    	$course_id=base64_decode($id);
    	$course=Course::find($course_id);
    	if($course!=null)
            return view('frontend.share.app',['id'=>$course_id,'type'=>'course']);
        else
           return view('frontend.share.app',['type'=>'home']);
    }
}
