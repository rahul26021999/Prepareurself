<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourceProjectViews;
use JWTAuth;

class ResourceProjectViewsController extends Controller
{
    
	/**
     * @OA\Post(
     *     path="/api/view-resource-project",
     *     tags={"Likes | Dislikes | Views"},
     *     description="View a resource or peoject in prepareurself",
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
    public function wsViewResource(Request $request)
    {
		$project_id=$request->input('project_id',null);
		$resource_id=$request->input('resource_id',null);
		if($project_id!=null || $resource_id!=null)
		{
			$already=ResourceProjectViews::where('user_id',JWTAuth::user()->id)
				->where('project_id',$project_id)
				->where('resource_id',$resource_id)
				->count();
			if($already==0)
			{
		    	ResourceProjectViews::create([
		    		'user_id'=>JWTAuth::user()->id,
		    		'project_id'=>$project_id,
		    		'resource_id'=>$resource_id,
		    	]);
		    }
		    return response()->json(['success'=>true,'error_code'=>0,'message'=>"View successfull"]);
		
		}
		else{
			return response()->json(['success'=>false,'error_code'=>1,'message'=>"Both project_id and resource_id can't be null"]);
		}
    }
}
