<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenForumAnswer;
use App\Models\OpenForumQuestion;
use App\Models\OpenForumClaps;
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

		$replies=OpenForumAnswer::with(["User"=>function($query){
         $query->select('first_name','last_name','username','id','profile_image');
      }])->where('query_id',$query_id)->orderBy('created_at','desc')->paginate($count);
      
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
      },"OpenForumAnswer"])->where('course_id',$course_id)->orderBy('created_at','desc')->paginate($count);

		return response()->json([
			'queries'=>$queries,
			'error_code'=>0,
			'message'=>'Success'
		]);
	}

	public function getQuestionAnswerImage(Request $request){

	}
    
}
