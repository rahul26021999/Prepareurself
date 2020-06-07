<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseTopic;
use App\Models\CourseReviews;
use App\Models\Project;
use App\Models\UserPreferences;
use App\Exception;
use JWTAuth;
use Log;
use Session;

class CourseController extends Controller
{
   
   public function showCreateCourse()
   {        
        return view('backend.course.create');
   }
   public function createCourse(Request $request)
   {   	
      try{

   	   $fileName = time().'.'.$request->file('courseImage')->extension();  
       $request->file('courseImage')->move(public_path('uploads/courses'), $fileName);

        $course=course::create([
          'name'=>$request['name'],
          'image_url'=>$fileName,
          'description'=>$request['description']
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating Course ".$e);          
      }
      return redirect('/admin/course/all');  
   }
   public function showEditCourse($id)
   {
      $course=Course::find($id);
      return view('backend.course.edit',['course'=>$course]);
   }
   public function saveEditCourse(Request $request, $id)
   {
      try{
         $course=course::find($id);
         if($course!=null)
         {
            if($request->file('courseImage'))
            { 
              $fileName = time().'.'.$request->file('courseImage')->extension();  
              $request->file('courseImage')->move(public_path('uploads/courses'), $fileName);
              $course->image_url=$fileName;
            }
            $course->name=$request['name'];
            $course->description=$request['description'];
            $course->save();
         }
         else{
            abort(404);
         }
      }
      catch(Exception $e){
        Log::error("Error in saving question ".$e);    
      }
      return redirect('admin/course/all');
   }
   public function showAllCourse($type='all')
   {
      if($type=='all'){
        $course=Course::all();
      }
      elseif($type=='published'){
        $course=Course::all()->where('status','publish'); 
      }
      elseif($type=='unpublished'){
        $course=Course::all()->where('status','dev');
      }
      else{
        abort(404);
      }     
      return view('backend.course.show',['courses'=>$course,'type'=>$type]);
   }
   public function showCourse($id)
   {
     $course=Course::find($id);
     return view('backend.course.showsingle',['course'=>$course]);
   }
   public function publishCourse(Request $request)
   {
      if(isset($request['id']) && isset($request['status']) && $request['id']!='' && $request['status']!='')
      {
        $course=Course::find($request['id']);
        $course->status=$request['status'];
        $course->save();
        return response()->json(['success'=>true,'status'=>$course->status,'message'=>'Course Status changed to '.$course->status]);
      }
      else{
        return response()->json(['success'=>false,'message'=>"Course status can't change at this moment"]);
      }

   }


/**
   * @OA\Post(
   *     path="/api/get-courses",
   *     tags={"Courses"},
   *     description="Get all courses data",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *   
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
   public function wsGetAllCourses(Request $request){
      $courses=Course::where('status','publish')->get();
      return response()->json(['error_code'=>0,'courses'=>$courses]);
   }

   /**
   * @OA\Post(
   *     path="/api/get-all-preferences",
   *     tags={"User"},
   *     description="Get all Preferences for a User available in Prepareurself",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *   
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
   public function wsGetAllPreferences(Request $request)
   {
      $courses=Course::where('status','publish')->select('id','name')->get();
      return response()->json(['error_code'=>0,'preferences'=>$courses]);
   }

   public function changeCourseSequence(Request $request){
    $id=$request['id'];
      for ($i=0; $i < count($id); $i++) { 
        Course::find($id[$i])->update(['sequence'=>$i]);
      }
      Session::flash('success','You have Successfully changed sequence !');
      return redirect()->back();

   }

  /**
   * @OA\Post(
   *     path="/api/course",
   *     tags={"Courses"},
   *     description="Get a courses data",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="course_id",
   *          in="query",
   *          description="Course_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */

    public function wsGetCourse(Request $request){

      $id=$request['course_id'];
      $user=JWTAuth::user();
      $course=Course::find($id);
      $courseReview=CourseReviews::where(['user_id'=>$user->id,'course_id'=>$id])->pluck('rating')->first();
      if($courseReview==null)
        $courseReview=0;

      $topic_count=CourseTopic::where('course_id',$id)->count();
      $project_count=Project::where('course_id',$id)->count();
      
      $user_preference=UserPreferences::where(['user_id'=>$user->id,'course_id'=>$id])->exists();

      return response()->json([
        'error_code'=>0,
        'course'=>$course,
        'topic_count'=>$topic_count,
        'project_count'=>$project_count,
        'rating'=>$courseReview,
        'preference'=>$user_preference
      ]);

   }
}
