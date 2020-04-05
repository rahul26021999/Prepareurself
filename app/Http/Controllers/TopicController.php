<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\CourseTopic;
use App\Models\Course;
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

   	   $fileName = time().'.'.$request->file('topicImage')->extension();  
       $request->file('topicImage')->move(public_path('uploads/topics'), $fileName);

        $course=CourseTopic::create([
          'name'=>$request['name'],
          'image_url'=>$fileName,
          'course_id'=>$request['course_id']
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating Topic ".$e);          
      }
      return redirect('/admin/topic/all');  
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
         $CourseTopic=CourseTopic::find($id);
         if($CourseTopic!=null)
         {
            if($request->file('topicImage'))
            { 
              $fileName = time().'.'.$request->file('topicImage')->extension();  
              $request->file('topicImage')->move(public_path('uploads/topics'), $fileName);
              $CourseTopic->image_url=$fileName;
            }
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
      return redirect('admin/topic/all');
   }
   public function showAllCourseTopic($courseName)
   {
      $course=Course::where('name',$courseName)->first();
      if($course!=null)
      {
        $CourseTopic=CourseTopic::where('course_id',$course['id'])->get();
        return view('backend.topic.show',['courseTopic'=>$CourseTopic,'course'=>$course]);
      }
      else{
        abort(404);
      }
      
   }
}
