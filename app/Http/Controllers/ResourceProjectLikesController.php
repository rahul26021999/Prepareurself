<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourceProjectLikes;
use App\Models\Resource;
use App\Models\Project;
use JWTAuth;

class ResourceProjectLikesController extends Controller
{


	/**
     * @OA\Post(
     *     path="/api/hit-like",
     *     tags={"Likes | Dislikes | Views"},
     *     description="Like/Dislike a resource or peoject in prepareurself",
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
	 *          name="like",
	 *          in="query",
	 *          description="[0 => for like , 1 => for Dislike]",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="project_id",
	 *          in="query",
	 *          description="project id of a particular project u want to like or dislike",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="resource_id",
	 *          in="query",
	 *          description="resources id of a particular resource u want to like or dislike",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
     *     @OA\Response(
     *          response=200,
     *			description="{[success=>true,message=>'like successfull'],[success=>true,message=>'Dislike successfull']}"
     *     )
     * )
     */
    public function wsHitlike(Request $request)
    {
    	if(isset($request['like']))
    	{
    		$project_id=$request->input('project_id',null);
    		$resource_id=$request->input('resource_id',null);
    		if($project_id!=null || $resource_id!=null)
    		{
    			if($request['like']==0)
    			{
	    			$already=ResourceProjectLikes::where('user_id',JWTAuth::user()->id)
	    				->where('project_id',$project_id)
	    				->where('resource_id',$resource_id)
	    				->count();
	    			if($already==0)
	    			{
				    	ResourceProjectLikes::create([
				    		'user_id'=>JWTAuth::user()->id,
				    		'project_id'=>$project_id,
				    		'resource_id'=>$resource_id,
				    	]);
				    }
				    return response()->json(['success'=>true,'error_code'=>0,'message'=>"Liked successfull"]);
	    		}
	    		else{
	    			$already=ResourceProjectLikes::where('user_id',JWTAuth::user()->id)
	    				->where('project_id',$project_id)
	    				->where('resource_id',$resource_id)
	    				->delete();
	    			return response()->json(['success'=>true,'error_code'=>0,'message'=>"Unliked successfull"]);
	    		}
    		}
    		else{
    			return response()->json(['success'=>false,'error_code'=>1,'message'=>"Both project_id and resource_id can't be null"]);
    		}
    	}
    	else{
    		return response()->json(['success'=>false,'error_code'=>2,'message'=>"like field is required"]);
    	}
    }


    /**
   * @OA\Post(
   *     path="/api/get-my-liked-things",
   *     tags={"Likes | Dislikes | Views"},
   *     description="Get all my liked things data",
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
   *          name="count",
   *          in="query",
   *          description="Count ,If not passed by default value of count is 10",
   *          required=false,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *      ),
   *     @OA\Parameter(
   *           name="page",
   *          in="query",
   *          description="Page number , if not then by default page 1",
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
    public function wsGetMyLikedThing(Request $request){

    	$user=JWTAuth::user();
    	$count= isset($request['count'])?$request['count']:'10';
    	$likesItem=ResourceProjectLikes::where('user_id',$user->id)->paginate($count);

    	foreach ($likesItem as $item) {
    		if($item->resource_id!=null){
    			$resource=Resource::find($item->resource_id);
    			if($resource==null){
    				unset($item);
    			}
    			else{
    				$item->resource=$resource;
    			}
    		}
    		elseif($item->project_id!=null){
    			$project=Project::find($item->project_id);
    			if($project==null){
    				unset($item);
    			}
    			else{
    				$item->project=$project;
    			}
    		}
    		else{
    			unset($item);
    		}
    	}

    	return response()->json([
    		'error_code'=>0,
    		'likedItems'=>$likesItem
    	]);
    }
}
