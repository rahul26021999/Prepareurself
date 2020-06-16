<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenForumAnswer;
use App\Models\OpenForumQuestion;
use App\Models\OpenForumClap;
use App\Models\OpenForumAttachment;
use Exception;
use App\User;
use JWTAuth;
use Log;


class OpenForumController extends Controller
{

  /**
   * @OA\Post(
   *     path="/api/do-reply",
   *     tags={"Forum"},
   *     description="reply a query for a particular course",
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
   *          name="query_id",
   *          in="query",
   *          description="query_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="images[]",
   *          in="query",
   *          description="Attachment name in reply only images for now",
   *          required=false,
   *          @OA\Schema(
   *              type="array",
   *               @OA\Items(
   *                   type="string"
   *               ),              
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="reply",
   *          in="query",
   *          description="reply means your answer",
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
  public function doReply(Request $request)
  {
     $query_id=$request['query_id'];
     $reply=$request['reply'];
     $user_id=JWTAuth::user()->id;

     $forum=OpenForumAnswer::create([
      'user_id'=>$user_id,
      'reply'=>$reply,
      'query_id'=>$query_id
   ])->fresh();

     if (isset($request['images'])) {
       foreach ($request['images'] as $position => $image) {
        OpenForumAttachment::create([
         'query_id'=>null,
         'reply_id'=>$forum->id,
         'file'=>$image
      ]);
     }
  }

  return response()->json([
   'reply'=>$forum,
   'error_code'=>0,
   'message'=>"Successfully Created Query"
]); 
}

  /**
   * @OA\Post(
   *     path="/api/ask-query",
   *     tags={"Forum"},
   *     description="Ask a query for a particular course",
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
   *     @OA\Parameter(
   *          name="images[]",
   *          in="query",
   *          description="Attachment name in query only images for now",
   *          required=false,
   *          @OA\Schema(
   *              type="array",
   *               @OA\Items(
   *                   type="string"
   *               ),              
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="query",
   *          in="query",
   *          description="query means your question",
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

  public function askQuery(Request $request)
  {
     $course_id=$request['course_id'];
     $query=$request['query'];
     $user_id=JWTAuth::user()->id;

     $forum=OpenForumQuestion::create([
      'user_id'=>$user_id,
      'course_id'=>$course_id,
      'query'=>$query,
   ])->fresh();

     if (isset($request['images'])) {
       foreach ($request['images'] as $position => $image) {
        OpenForumAttachment::create([
         'query_id'=>$forum->id,
         'reply_id'=>null,
         'file'=>$image
      ]);
     }
  }

  return response()->json([
   'query'=>$forum,
   'error_code'=>0,
   'message'=>"Successfully Created Query"
]); 
}

  /**
   * @OA\Post(
   *     path="/api/edit-query",
   *     tags={"Forum"},
   *     description="edit a query for a particular course asked by you",
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
   *          name="query_id",
   *          in="query",
   *          description="query_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="query",
   *          in="query",
   *          description="query means your question",
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
  public function editQuery(Request $request)
  {
     $query_id=$request['query_id'];
     $query=$request['query'];
     $forum=OpenForumQuestion::updateOrCreate(['id'=>$query_id],['query'=>$query]);
     return response()->json([
      'query'=>$forum,
      'error_code'=>0,
      'message'=>"Successfully updated Query"
   ]); 
  }

  /**
   * @OA\Post(
   *     path="/api/get-query-replies",
   *     tags={"Forum"},
   *     description="get replies for a query for a particular course",
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
   *          name="query_id",
   *          in="query",
   *          description="query_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="count",
   *          in="query",
   *          description="count no of query replies in  a page default count is 10",
   *          required=false,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
    *     @OA\Parameter(
   *          name="page",
   *          in="query",
   *          description="page no for query replies default page is 1 ",
   *          required=false,
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

  public function getQueryReplies(Request $request)
  {
     $query_id=$request['query_id'];
     $count=$request->input('count',10);

     $replies=OpenForumAnswer::with(["OpenForumAttachment","User"=>function($query){
      $query->select('first_name','last_name','username','id','profile_image');
   }])->withCount(['OpenForumClap as clap'=>function($query){
      $query->where('user_id',JWTAuth::user()->id);
   },'OpenForumClap as total_claps'])
   ->where('query_id',$query_id)->orderBy('created_at','desc')->paginate($count);

   return response()->json([
      'query'=>$replies,
      'error_code'=>0,
      'message'=>'Success'
   ]);
}

  /**
   * @OA\Post(
   *     path="/api/get-queries",
   *     tags={"Forum"},
   *     description="get queries for a particular course",
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
   *          description="course_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="count",
   *          in="query",
   *          description="count no of queries in  a page default count is 10",
   *          required=false,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
    *     @OA\Parameter(
   *          name="page",
   *          in="query",
   *          description="page no for queries default page is 1 ",
   *          required=false,
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

  public function getQueries(Request $request)
  {
     $course_id=$request['course_id'];
     $count=$request->input('count',10);

     $queries=OpenForumQuestion::with(["User"=>function($query){
      $query->select('first_name','last_name','username','id','profile_image');
   },"OpenForumAnswer","OpenForumAttachment"])->where('course_id',$course_id)->orderBy('created_at','desc')->paginate($count);

     return response()->json([
      'queries'=>$queries,
      'error_code'=>0,
      'message'=>'Success'
   ]);
  }

    /**
    * @OA\Post(
    *     path="/api/upload-query-image",
    *     tags={"Forum"},
    *     description="upload a image of a query",
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
    *          name="type",
    *          in="query",
    *          description="0: if image belongs to query and 1 if image belongs to replies",
    *          required=true,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *     @OA\Parameter(
    *          name="image",
    *          in="query",
    *          description="image to be uploaded",
    *          required=true,
    *          @OA\Schema(
    *              type="file"
    *          )
    *      ),
     *     @OA\Response(
     *          response=200,
     *         description="{[error_code=>0,msg=>'uploaded Successfully Done']}"
     *     )
     * )
     */

    public function getQueryImage(Request $request)
    {
      try{
         if($request->file('image') && $request->filled('type'))
         {
            $fileName = time().'.'.$request->file('image')->extension();  
            if($request->input('type')==0){
               $request->file('image')->move(public_path('uploads/openforum/queries'), $fileName);
               $path=url('/').'/uploads/openforum/queries/'.$fileName;
            }
            else{
               $request->file('image')->move(public_path('uploads/openforum/replies'), $fileName);
               $path=url('/').'/uploads/openforum/replies/'.$fileName;
            }
            return response()->json([
               "error_code"=>0,
               "image"=>$fileName,
               "path"=>$path,
               "message"=>"uploaded Successfully"
            ]);
         }    
         else{
            return response()->json([
               "error_code"=>1,
               "message"=>"missing Image or type",
            ]);
         }
      }catch(Exception $e){
         return response()->json([
            "error_code"=>2,
            "message"=>"Error in Uploading Image Try again"
         ]);
      }
   }

    /**
   * @OA\Post(
   *     path="/api/clap-on-reply",
   *     tags={"Forum"},
   *     description="clap replies for a query for a particular course",
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
   *          name="reply_id",
   *          in="query",
   *          description="reply_id of a course",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="status",
   *          in="query",
   *          description="0=>to add clap and 1 to remove clap",
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

    public function clapOnReply(Request $request)
    {
      if($request->filled('status') && $request->input('reply_id')){
         if($request['status']==0){
            $clap=OpenForumClap::create([
               "user_id"=>JWTAuth::user()->id,
               "reply_id"=>$request['reply_id']
            ])->fresh();

            return response([
               "error_code"=>0,
               "clap"=>$clap,
               "message"=>"successfully clapped"
            ]);
         }
         else{
            OpenForumClap::where(["user_id"=>JWTAuth::user()->id,"reply_id"=>$request['reply_id']])->delete();
            return response([
               "error_code"=>0,
               "message"=>"successfully removed clapped"
            ]);
         }
      }else{
         return response([
            "error_code"=>1,
            "message"=>"reply id and status is required"
         ]);
      }
      
   }

}
