<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\Models\Resource;
use App\Models\CourseTopic;
use App\Models\Course;
use Log;

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
}
