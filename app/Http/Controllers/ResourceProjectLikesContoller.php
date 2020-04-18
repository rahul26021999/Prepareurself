<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourceProjectLikes;
use JWTAuth;
use Request;

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
	 *          description="[true => for like , false => for Dislike]",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="boolean"
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
    public function wsHitlike()
    {
    	if(isset($request['like']))
    	{
    		$project_id=$request->input('project_id',null);
    		$resource_id=$request->input('resource_id',null);
    		if($project_id!=null || $resource_id!=null)
    		{
    			if($request['like'])
    			{
	    			$already=ResourceProjectLikes::where('user_id',JWTAuth::user()->id)
	    				->where('project_id',$project_id)
	    				->where('resource_id',$resource_id)
	    				->count();
	    			if(count($already)==0)
	    			{
				    	ResourceProjectLikes::create([
				    		'user_id'=>JWTAuth::user()->id,
				    		'project_id'=>$project_id,
				    		'resource_id'=>$resource_id;	
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
}
