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
          $CourseTopic=CourseTopic::where('course_id',$course['id'])->get();
          return view('backend.topic.show',['courseTopic'=>$CourseTopic,'course'=>$course]);
        }
        else{
          abort(404);
        }
      }
      
   }
   /**
     * @OA\Post(
     *     path="/api/get-topics",
     *     tags={"Topics"},
     *     description="Get all topics of a particular course",
   *     @OA\Parameter(
   *          name="course_id",
   *          in="query",
   *          description="Course id of course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *     ),
   *     @OA\Parameter(
   *          name="count",
   *          in="query",
   *          description="Count of resources,If not passed by default value of count is 10",
   *          required=false,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="page_number",
   *          in="query",
   *          description="Page number , if not then by default page 1",
   *          required=false,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Response(
     *          response=200,
     *      description="{[error_code=>0,msg=>'success'],[error_code=>1,msg=>'Course Id is Invalid'],[error_code=>2,'msg'=>'Course Id is Compulsory']}"
     *     )
     * )
     */

   public function wsGetAllTopics(Request $request){
     if(isset($request['course_id'])){

       $course=Course::where('id',$request['course_id'])->first();
        if($course!=null)
        {
          $pageNumber= isset($request['page_number'])?$request['page_number']:'1';
          $count= isset($request['count'])?$request['count']:'10';
          $CourseTopic=CourseTopic::where('course_id',$course['id'])->paginate($count, ['*'],'page',$pageNumber);;
          return json_encode(['error_code'=>0,'topics'=>$CourseTopic]);
        }
        else{
          return json_encode(['error_code'=>1,'msg'=>'Course Id is Invalid']);
        }
     }
     else{
       return json_encode(['error_code'=>2,'msg'=>'Course Id is Compulsory']);
     }
   }

}
