<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Log;
use App\Exception;

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
      $course=Course::all();
      return view('backend.course.show',['courses'=>$course]);
   }
   public function showCourse($id)
   {
     $course=Course::find($id);
     return view('backend.course.showsingle',['course'=>$course]);
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
    $courses=Course::all()->where('status','publish');
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
      $courses=Course::all('id','name')->where('status','publish');
      return response()->json(['error_code'=>0,'preferences'=>$courses]);
   }

}
