<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Project;
use App\Models\Course;
use App\Models\CourseTopic;

class SearchController extends Controller
{
	 /**
	 * @OA\Post(
	 *     path="/api/search",
	 *     tags={"Search"},
	 *     description="Get all search related items",
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
	 *          name="query",
	 *          in="query",
	 *          description="string data needs to be search",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="count",
	 *          in="query",
	 *          description="Count of result,If not passed by default value of count is 10",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="page",
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

	 public function search(Request $request)
	 {
	 	$result = array();
	 	$query=$request['query'];
	 	$count=isset($request['count'])?$request['count']:10;
	 	$pageNumber=isset($request['page'])?$request['page']:1;
	 	$totalResult=0;

	 	$topics=CourseTopic::where('status', 'publish')
	 	->where('name', 'like', '%' . $query . '%')->skip($count*($pageNumber-1))->take($count)->get();

	 	if(count($topics)>0){
	 		$totalResult=count($topics);
	 		$topicsArray = array(
	 			'type' => 'topics',
	 			'topics' => $topics
	 		);
	 		array_push($result,$topicsArray);	
	 	}

	 	if($totalResult<$count){

	 		$topicCountTotal=CourseTopic::where('status', 'publish')
	 		->where('name', 'like', '%' . $query . '%')->count();

	 		$remaining=$count-$totalResult;
	 		$skip=$count*($pageNumber-1)-$topicCountTotal;

	 		$projects=Project::where('status', 'publish')
	 		->where(function($q) use ($query) {
				$q->where('name', 'like', '%' . $query . '%')
				->orWhere('description', 'like', '%' . $query . '%');
			})
	 		->skip($skip)->take($remaining)
	 		->get();

	 		if(count($projects)>0){
	 			$totalResult=$totalResult+count($projects);
	 			$topicsArray = array(
	 				'type' => 'projects',
	 				'projects' => $projects
	 			);
	 			array_push($result,$topicsArray);	

	 		}
	 	}
	 	if($totalResult<$count){

	 		$remaining=$count-$totalResult;

	 		$totalProjectsCount=Project::where('status', 'publish')
	 		->where('name', 'like', '%' . $query . '%')->count();

	 		$skip=$count*($pageNumber-1)-$topicCountTotal-$totalProjectsCount;

	 		$resource=Resource::whereHas('CourseTopic', function ($query) {
									$query->where('status', 'publish');
								})
	 							->where(function($q) use ($query) {
	 								$q->where('title', 'like', '%' . $query . '%')
	 								->orWhere('description', 'like', '%' . $query . '%');
	 							})
					    		->skip($skip)->take($remaining)->get();

	 		if(count($resource)>0){
	 			$totalResult=$totalResult+count($resource);
	 			$topicsArray = array(
	 				'type' => 'resource',
	 				'resource' => $resource
	 			);
	 			array_push($result,$topicsArray);	
	 		}
	 	}

	 	return response()->json([
	 		'error_code'=>0,
	 		'success'=>true,
	 		'data'=>$result
	 	]);

	}

	/**
	 * @OA\Post(
	 *     path="/api/search-without-pagination",
	 *     tags={"Search"},
	 *     description="Get all search related items",
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
	 *          name="query",
	 *          in="query",
	 *          description="string data needs to be search",
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
	 public function searchWithOutPagination(Request $request)
	 {
	 	$result = array();
    	$query=$request['query'];

    	$topics=CourseTopic::where('status', 'publish')
    		->where('name', 'like', '%' . $query . '%')
	        ->get();

	    if(count($topics)>0){
	    	$topicsArray = array(
		    	'type' => 'topics',
		    	'topics' => $topics
		    );
		    array_push($result,$topicsArray);	
	    }
	    
		$projects=Project::where('status', 'publish')
	 		->where(function($q) use ($query) {
				$q->where('name', 'like', '%' . $query . '%')
				->orWhere('description', 'like', '%' . $query . '%');
			})->get();

	    if(count($projects)>0){
	    	$projectsArray = array(
		    	'type' => 'projects',
		    	'projects' => $projects
		    );
		    array_push($result,$projectsArray);	
	    }
	    

	    $resources=Resource::whereHas('CourseTopic', function ($query) {
									$query->where('status', 'publish');
								})
	 							->where(function($q) use ($query) {
	 								$q->where('title', 'like', '%' . $query . '%')
	 								->orWhere('description', 'like', '%' . $query . '%');
	 							})->get();

	  	if(count($resources)>0)
	  	{
	  		  $resourcesArray = array(
		    	'type' => 'resources',
		    	'resources' => $resources
		    );

		    array_push($result,$resourcesArray);

	  	}

	    return response()->json([
	    	'error_code'=>0,
	    	'data'=>$result
	    ]);
	}

		 /**
	 * @OA\Post(
	 *     path="/api/search-inside-course",
	 *     tags={"Search"},
	 *     description="Get all search related items for a particular course",
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
	 *          name="query",
	 *          in="query",
	 *          description="string data needs to be search",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="course_id",
	 *          in="query",
	 *          description="course_id for the course",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="count",
	 *          in="query",
	 *          description="Count of result,If not passed by default value of count is 10",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="page",
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

	public function searchCourse(Request $request)
	{

		$result = array();
	 	$query=$request['query'];
	 	$course_id=$request['course_id'];
	 	$count=isset($request['count'])?$request['count']:10;
	 	$pageNumber=isset($request['page'])?$request['page']:1;
	 	$totalResult=0;

 		$projects=Project::where('status', 'publish')
 		->where('course_id',$course_id)
 		->where(function($q) use ($query) {
			$q->where('name', 'like', '%' . $query . '%')
			->orWhere('description', 'like', '%' . $query . '%');
		})
 		->skip($count*($pageNumber-1))->take($count)
 		->get();

 		if(count($projects)>0){
 			$totalResult=$totalResult+count($projects);
 			$topicsArray = array(
 				'type' => 'projects',
 				'projects' => $projects
 			);
 			array_push($result,$topicsArray);	
 		}
 	
	 	if($totalResult<$count){

	 		$remaining=$count-$totalResult;

	 		$totalProjectsCount=Project::where('status', 'publish')
	 		->where('name', 'like', '%' . $query . '%')->count();

	 		$skip=$count*($pageNumber-1)-$topicCountTotal-$totalProjectsCount;

	 		$resource=Resource::whereHas('CourseTopic', function ($query) {
									$query->where('status', 'publish');
									$query->where('course_id', $course_id);
								})
	 							->where(function($q) use ($query) {
	 								$q->where('title', 'like', '%' . $query . '%')
	 								->orWhere('description', 'like', '%' . $query . '%');
	 							})
					    		->skip($skip)->take($remaining)->get();

	 		if(count($resource)>0){
	 			$totalResult=$totalResult+count($resource);
	 			$topicsArray = array(
	 				'type' => 'resource',
	 				'resource' => $resource
	 			);
	 			array_push($result,$topicsArray);	
	 		}
	 	}

	 	return response()->json([
	 		'error_code'=>0,
	 		'success'=>true,
	 		'data'=>$result
	 	]);
	}
}
