<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Banner;
use App\Exception;

class BannerController extends Controller
{
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
