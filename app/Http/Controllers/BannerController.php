<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Banner;
use App\Models\Course;
use App\Exception;
use Session;

class BannerController extends Controller
{

   public function showCreateBanner()
   {        
        return view('backend.banner.create');
   }
   public function createBanner(Request $request)
   {    
      try{

       $fileName = time().'.'.$request->file('bannerImage')->extension();  
       $request->file('bannerImage')->move(public_path('uploads/banners'), $fileName);

        $banner=Banner::create([
          'title'=>$request['title'],
          'image'=>$fileName,
          'status'=>$request->input('publish','dev'),
          'screen'=>$request['screen'],
          'screen_id'=>$request->input('id',null),
        ]);
      }
      catch(Exception $e){
          Log::error("Error in creating Banner ".$e);          
      }
      return redirect('admin/banner/show');
   }
   public function showbanner(Request $request)
   {
      $banner=Banner::all();
      return view('backend.banner.show',['banners'=>$banner]);
   }

   public function showEditBanner($id){
    $banner=Banner::find($id);
    return view('backend.banner.edit',['banner'=>$banner]); 
   }

   public function saveEditBanner(Request $request, $id)
   {
     try
    {
      $banner=Banner::find($id);
      if($banner!=null)
      {
        if($request->file('bannerImage'))
        { 
          $fileName = time().'.'.$request->file('bannerImage')->extension();  
          $request->file('bannerImage')->move(public_path('uploads/banners'), $fileName);
          $banner->image=$fileName;
        }
        $banner->title=$request['title'];
        $banner->status=$request->input('publish','dev');
        $banner->screen=$request['screen'];
        $banner->screen_id=$request['id'];
          $banner->save();
      }
      else{
        abort(404);
      }
    }
    catch(Exception $e){
      Log::error("Error in saving banner".$e);    
    }
    return redirect('admin/banner/show');

   }

   public function deleteBanner(Request $request)
  {
    $id=$request['id'];
    $name=$request['title'];
    $success=Banner::find($id)->delete();
    if($success!=null)
    {
      Session::flash("success","You have Successfully Deleted ".$name);
      return redirect()->back();
    }

  }
   public function publishBanner(Request $request)
   {
      if(isset($request['id']) && isset($request['status']) && $request['id']!='' && $request['status']!='')
      {
        $banner=Banner::find($request['id']);
        $banner->status=$request['status'];
        $banner->save();
        return response()->json(['success'=>true,'status'=>$banner->status,'message'=>'Banner Status changed to '.$banner->status]);
      }
      else{
        return response()->json(['success'=>false,'message'=>"banner status can't change at this moment"]);
      }
   }

    /**
   * @OA\Post(
   *     path="/api/get-banner",
   *     tags={"Banner"},
   *     description="Get all banner image and title  in Prepareurself",
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

  public function wsGetBanner(Request $request){
      $banners=Banner::where('status','publish')->get();
      foreach ($banners as $banner) {
          switch ($banner->screen) {
              case 'allTopic' || 'allbanner' || 'allCourse' || 'course' :
                  $banner->course=Course::find($banner['screen_id']);
                break;
          }
      }
      return response()->json(['error_code'=>0,'banner'=>$banners]); 
  }

}
