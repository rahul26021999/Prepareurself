<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Banner;
use App\Exception;

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
          'status'=>$request->input('publish','dev')
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
      $banner=Banner::where('status','publish')->select('id','title','image')->get();
      return response()->json(['error_code'=>0,'banner'=>$banner]);
  }
}
