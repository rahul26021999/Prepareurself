<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\User;
use JWTAuth;
use App\Models\Course;
use App\Models\CourseTopic;
use App\Models\Project;
use App\Exception;

trait SuggestedCourseTrait {
	
	
	public function getSuggestedTopicCourse(Request $request){
		$user=JWTAuth::user();
		$course_id=1; // Android
		
		if(!is_null($user->preferences)  && $user->preferences!='')
		{
			$preferences=explode(',', $user->preferences);
			$course_name=$preferences['0'];
			
			$course=Course::where('name',$course_name)->where('status','publish')->first();
			if($course!=null)
			{
				$count=CourseTopic::where('course_id',$course->id)->where('status','publish')->count();
				if($count>3)
				{
					$course_id=$course->id;
				}
			}
		}
		return $course_id;
	}
	

	public function getSuggestedProjectCourse(Request $request){
		$user=JWTAuth::user();
		$course_id=4;//PHP

		if(!is_null($user->preferences)  && $user->preferences!='')
		{
			$preferences=explode(',', $user->preferences);
			$course_name=$preferences['0'];

			$course=Course::where('name',$course_name)->where('status','publish')->first();
			if($course!=null)
			{
				$count=Project::where('course_id',$course->id)
				->where('status','publish')
				->count();
				if($count>3)
				{
					$course_id=$course->id;
				}
			}
		}
		return $course_id;
	}
}