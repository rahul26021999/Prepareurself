<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Resource;
use App\Models\Course;

class ShareController extends Controller
{
	protected $HOME_SCHEME="prepareurself_home://prepareurself.tk/?";
	protected $COURSE_SCHEME="prepareurself_course://prepareurself.tk/?";
	protected $RESOURCE_SCHEME="prepareurself_resource://prepareurself.tk/?";

	protected $HOME_ACTIVITY='.Home.ui.HomeActivity';
	protected $RESOURCE_ACTIVITY='.Home.content.resources.ui.activity.ResourcesActivity';
	protected $COURSE_ACTIVITY='.Home.content.courses.ui.activity.CoursesActivity';


    public function share()
    {
    	$link=$this->HOME_SCHEME."screen=".$this->HOME_ACTIVITY;
    	return view('frontend.share.app',['link'=>$link]);
    }
    public function shareResource($id)
    {
    	$resource_id=base64_decode($id);
    	$resource=Resource::find($resource_id);
    	if($resource!=null)
    		$link=$this->RESOURCE_SCHEME."screen=".$this->RESOURCE_ACTIVITY."&type=".$resource->type."&id=".$resource->id;
    	else
    		$link=$this->HOME_SCHEME."screen=".$this->HOME_ACTIVITY;

    	return view('frontend.share.app',['link'=>$link]);
    }
    public function shareProject($id)
    {
    	$project_id=base64_decode($id);
    	$project=Project::find($project_id);
    	if($project!=null)
    		$link=$this->COURSE_SCHEME."screen=".$this->COURSE_ACTIVITY."&id=".$project->id;
    	else
    		$link=$this->HOME_SCHEME."screen=".$this->HOME_ACTIVITY;

    	return view('frontend.share.app',['link'=>$link]);
    }
    public function shareCourse($id)
    {

    	$course_id=base64_decode($id);
    	$course=Course::find($course_id);
    	if($course!=null)
    		$link=$this->COURSE_SCHEME."screen=".$this->COURSE_ACTIVITY."&id=".$course->id;
    	else
    		$link=$this->HOME_SCHEME."screen=".$this->HOME_ACTIVITY;
		
		return view('frontend.share.app',['link'=>$link]);
    }
}
