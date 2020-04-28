<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\CourseTopic;
use App\Models\Course;
use App\Models\Resource;
use Log;
use Session;
use JWTAuth;

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
          $CourseTopic=CourseTopic::withCount(['Resource as resource_video'=>function($query){
                      $query->where('type','video');},
                    'Resource as resource_theory'=>function($query){
                      $query->where('type','theory');}])
          ->where('course_id',$course['id'])->orderBy('sequence','asc')->get();

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
      Session::flash('success','You have Successfully deleted a topic from '.$courseName);
      return redirect('/admin/topic/all/'.$courseName);
   }

   public function changeCourseTopicSequence(Request $request)
   {
      $id=$request['id'];
      for ($i=0; $i < count($id); $i++) { 
        CourseTopic::find($id[$i])->update(['sequence'=>$i]);
      }
      Session::flash('success','You have Successfully change sequence !');
      return redirect()->back();
   }
   public function publishCourseTopic(Request $request)
   {
      if(isset($request['id']) && isset($request['status']) && $request['id']!='' && $request['status']!='')
      {
        $course=CourseTopic::find($request['id']);
        $course->status=$request['status'];
        $course->save();
        return response()->json(['success'=>true,'status'=>$course->status,'message'=>'Topic Status changed to '.$course->status]);
      }
      else{
        return response()->json(['success'=>false,'message'=>"Topic status can't change at this moment"]);
      }

   }
   public function publishAllCourseTopic($courseId)
   {
      CourseTopic::where('course_id',$courseId)->update(['status'=>'publish']);
      return redirect()->back();
   }

   /**
   * @OA\Post(
   *     path="/api/get-topics",
   *     tags={"Topics"},
   *     description="Get all topics of a particular course",
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
   *          name="page",
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
          $count= isset($request['count'])?$request['count']:'10';
          $CourseTopic=CourseTopic::where('course_id',$course['id'])->where('status','publish')->orderBy('sequence','asc')->paginate($count);
          return response()->json(['error_code'=>0,'topics'=>$CourseTopic]);
        }
        else{
          return response()->json(['error_code'=>1,'msg'=>'Course Id is Invalid']);
        }
     }
     else{
       return response()->json(['error_code'=>2,'msg'=>'Course Id is Compulsory']);
     }
   }

   /**
   * @OA\Post(
   *     path="/api/get-suggested-topics",
   *     tags={"Topics"},
   *     description="Get all topics suggested for a particular user",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
   *          required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success']}"
   *     )
   * )
   */
   public function wsGetAllSuggestedTopics(Request $request){
      
      $user=JWTAuth::user();
      if(!is_null($user->preferences)  && $user->preferences!=''){
        $preferences=explode(',', $user->preferences);
        $course_id=$preferences['0'];
        if(CourseTopic::where('course_id',$course_id)->where('status','publish')->count()==0){
          $course_id=8;
        }
      }
      else{
        $course_id=8;
      }
      $topic=CourseTopic::where('course_id',$course_id)->where('status','publish')->orderBy('sequence','asc')->take(5)->get();
      return response()->json(['success'=>true,'course_id'=>$course_id,'topics'=>$topic]);

   }

}
