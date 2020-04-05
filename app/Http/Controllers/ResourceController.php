<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\Resource;
use App\Models\CourseTopic;

class ResourceController extends Controller
{
   public function showCreateResource($topicId)
   {        
   		$topic=CourseTopic::find($topicId);
        return view('backend.resource.create',['topic'=>$topic]);
   }
   public function createResource(Request $request)
   {   	
      try{
       $course=Course::find($request['course_id']);
   	   $fileName = time().'.'.$request->file('topicImage')->extension();  
       $request->file('topicImage')->move(public_path('uploads/topics'), $fileName);

        $courseTopic=CourseTopic::create([
          'name'=>$request['name'],
          'image_url'=>$fileName,
          'course_id'=>$request['course_id']
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating Topic ".$e);          
      }
      return redirect('/admin/topic/all/'.$course['name']);  
   }
   public function showEditResource($id)
   {
      $courses=Course::all();
      $CourseTopic=CourseTopic::find($id);
      return view('backend.topic.edit',['courseTopic'=>$CourseTopic,'courses'=>$courses]);
   }
   public function saveEditResource(Request $request, $id)
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
   public function showAllResource($courseName)
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
