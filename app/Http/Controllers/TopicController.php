<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\CourseTopic;
use App\Models\Course;
use App\Models\Resource;
use Log;

class TopicController extends Controller
{
   public function showCreateCourseTopic($courseName='')
   {        
        if($courseName!='')
        {
          $courses=Course::where('name',$courseName)->get();
          if(count($courses)==0)
          {
              abort(404);
          }
        }
        else{
          $courses=Course::all();
        }
        return view('backend.topic.create',['courses'=>$courses]);
   }
   public function createCourseTopic(Request $request)
   {   	
      try{
       $course=Course::find($request['course_id']);
   	   $fileName = time().'.'.$request->file('topicImage')->extension();  
       $request->file('topicImage')->move(public_path('uploads/topics'), $fileName);

        $courseTopic=CourseTopic::create([
          'name'=>$request['name'],
          'image_url'=>$fileName,
          'description'=>$request['description'],
          'course_id'=>$request['course_id']
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating Topic ".$e);          
      }
      return redirect('/admin/topic/all/'.$course['name']);  
   }
   public function showEditCourseTopic($id)
   {
      $courses=Course::all();
      $CourseTopic=CourseTopic::find($id);
      return view('backend.topic.edit',['courseTopic'=>$CourseTopic,'courses'=>$courses]);
   }
   public function saveEditCourseTopic(Request $request, $id)
   {
      try{
         $course=Course::find($request['course_id']);
         $CourseTopic=CourseTopic::find($id);
         if($CourseTopic!=null)
         {
            if($request->file('topicImage'))
            { 
              $fileName = time().'.'.$request->file('topicImage')->extension();  
              $request->file('topicImage')->move(public_path('uploads/topics'), $fileName);
              $CourseTopic->image_url=$fileName;
            }
            $CourseTopic->description=$request['description'];
            $CourseTopic->name=$request['name'];
            $CourseTopic->course_id=$request['course_id'];
            $CourseTopic->save();
         }
         else{
            abort(404);
         }
      }
      catch(Exception $e){
        Log::error("Error in saving question ".$e);    
      }
      return redirect('admin/topic/all/'.$course['name']);
   }
   public function showAllCourseTopic($courseName='')
   {
      if($courseName=='')
      {
        $CourseTopic=CourseTopic::with('Course')->get();
        return view('backend.topic.all',['courseTopic'=>$CourseTopic]);
      }
      else
      {
        $course=Course::where('name',$courseName)->first();
        if($course!=null)
        {
          $CourseTopic=CourseTopic::with('Resource')->where('course_id',$course['id'])->orderBy('sequence','asc')->get();
          return view('backend.topic.show',['course'=>$course,'courseTopic'=>$CourseTopic]);
        }
        else{
          abort(404);
        }
      }
      
   }
   public function deleteCourseTopic(Request $request)
   {
      $courseName=$request['courseName'];
      $id=$request['id'];      
      CourseTopic::find($id)->delete($id);
      if(isset($request['resourceAlso']) &&  $request['resourceAlso']==1)
      {
        $resourceCount=Resource::where('course_topic_id',$id)->count();
        if($resourceCount>0)
        Resource::where('course_topic_id',$id)->delete();
      }
      return redirect('/admin/topic/all/'.$courseName);
   }

   public function changeCourseTopicSequence(Request $request)
   {
      $id=$request['id'];
      for ($i=0; $i < count($id); $i++) { 
        CourseTopic::find($id[$i])->update(['sequence'=>$i]);
      }
      return redirect()->back();
   }
}
