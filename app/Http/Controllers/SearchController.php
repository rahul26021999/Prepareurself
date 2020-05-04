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

    	$courses=Course::where('name', 'like', '%' . $query . '%')
    		->where('status', 'publish')
	        ->get();

	    if(count($courses)>0){

	    	$courseArray = array(
		    	'type' => 'courses',
		    	'courses' => $courses
		    );
		    array_push($result,$courseArray);
	    }

    	$topics=CourseTopic::where('name', 'like', '%' . $query . '%')
	        ->where('description', 'like', '%' . $query . '%')
	        ->where('status', 'publish')
	        ->get();

	    if(count($topics)>0){
	    	$topicsArray = array(
		    	'type' => 'topics',
		    	'topics' => $topics
		    );
		    array_push($result,$topicsArray);	
	    }
	    
    	$projects=Project::where('name', 'like', '%' . $query . '%')
	        ->where('description', 'like', '%' . $query . '%')
	        ->where('status', 'publish')
	        ->get();

	    if(count($projects)>0){
	    	$projectsArray = array(
		    	'type' => 'projects',
		    	'projects' => $projects
		    );
		    array_push($result,$projectsArray);	
	    }
	    

	    $resources=Resource::where('title', 'like', '%' . $query . '%')
	        ->where('description', 'like', '%' . $query . '%')
	        ->get();

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
}
