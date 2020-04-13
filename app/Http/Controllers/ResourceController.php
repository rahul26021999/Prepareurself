<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\Resource;
use App\Models\CourseTopic;
use App\Models\Course;
use Session;
use Log;
use Auth;

class ResourceController extends Controller
{
   public function showCreateResource($topicId)
   {        
   		$topic=CourseTopic::find($topicId);
      return view('backend.resource.create',['topic'=>$topic]);
   }
   public function createResource(Request $request,$topicId)
   {   	
      try{
        $resource=Resource::create([
          'course_topic_id'=>$topicId,
          'link'=>$request['link'],
          'title'=>$request['title'],
          'admin_id'=>Auth::user()->id,
          'description'=>$request['description'],
          'type'=>$request['type']
        ]);

        if($request->file('backImage'))
        {
          Log::info("backImage found");
   	      $fileName = time().'.'.$request->file('backImage')->extension();  
          $request->file('backImage')->move(public_path('uploads/resources'), $fileName);
          $resource->image_url=$fileName;
          $resource->save();
        }
      }
      catch(Exception $e){
          Log::error("Error in creating Resource ".$e);          
      }
      return redirect('/admin/resource/all/'.$topicId);  
   }
   public function showEditResource($id)
   {
      $resource=Resource::with('CourseTopic')->where('id','=',$id)->get()->first();
      if($resource!=null)
      {
        return view('backend.resource.edit',['resource'=>$resource]);  
      }
      else{
        abort(404);
      }
   }
   public function saveEditResource(Request $request, $id)
   {
      try
      {
        $resource=Resource::find($id);
        if($resource!=null)
        {
          $resource->link=$request['link'];
          $resource->title=$request['title'];
          $resource->description=$request['description'];
          $resource->type=$request['type'];
          if($request->file('backImage'))
          {
            $fileName = time().'.'.$request->file('backImage')->extension();  
            $request->file('backImage')->move(public_path('uploads/resources'), $fileName);
            $resource->image_url=$fileName;
          }      
          $resource->save();
        }
        else{
          abort(404);
        }
      }
      catch(Exception $e){
          Log::error("Error in Editing Resource ".$e);          
      }
      return redirect('/admin/resource/all/'.$resource->course_topic_id);  
   }
   public function showAllResource($topicId='')
   {
      if($topicId=='')
      {
        $resources=Resource::with('CourseTopic')->get();
        return view('backend.resource.all',['resources'=>$resources]);  
      }
      else{
        $topic=CourseTopic::find($topicId);
        $resources=Resource::where('course_topic_id',$topicId)->get();
        return view('backend.resource.show',['topic'=>$topic,'resources'=>$resources]);
      }
   }

   public function deleteResource(Request $request)
   {
     $id=$request['id'];
     $title=$request['title'];
     Resource::find($id)->delete();
     Session::flash("success","You have Successfully Deleted ".$title);
     return redirect()->back();
   }


   /**
     * @OA\Post(
     *     path="/api/get-resources",
     *     tags={"Resources"},
     *     description="Get all resources of a particular topic",
   *     @OA\Parameter(
   *          name="topic_id",
   *          in="query",
   *          description="topic_id of Topic ",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *     ),
   *     @OA\Parameter(
   *          name="type",
   *          in="query",
   *          description="Type of resources : theory|video",
   *          required=false,
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
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
     *      description="{[error_code=>0,msg=>'success'],[error_code=>1,msg=>'Topic Id is Invalid'],[error_code=>2,'msg'=>'Topic Id is Compulsory']}"
     *     )
     * )
     */
   
   public function wsGetAllResources(Request $request){
      if(isset($request['topic_id'])){
          $topic=CourseTopic::find($request['topic_id']);
          if($topic!=null){
              $type=isset($request['type'])?$request['type']:'';
              $pageNumber= isset($request['page_number'])?$request['page_number']:'1';
              $count= isset($request['count'])?$request['count']:'10';
              if($type=='')
              {
                $resources=Resource::where('course_topic_id',$request['topic_id'])->paginate($count, ['*'],'page',$pageNumber);
                return json_encode(['error_code'=>0,'resources'=>$resources]);
              }
              else{
                $resources=Resource::where('course_topic_id',$request['topic_id'])
                          ->where('type',$type)
                          ->paginate($count, ['*'],'page',$pageNumber);
                return json_encode(['error_code'=>0,'resources'=>$resources]);
              }
          }
          else{
            return json_encode(['error_code'=>1,'msg'=>'Topic Id is Invalid']);
          }
      }
      else{
       return json_encode(['error_code'=>2,'msg'=>'Topic Id is Compulsory']);
      }
      
   }
}
