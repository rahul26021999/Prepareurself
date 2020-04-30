<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Course;
use Log;
use App\Exception;
use Session;
use Auth;
use JWTAuth;


class ProjectController extends Controller
{
	public function showCreateProject($courseName='')
	{     
		if($courseName!='')
		{
			$courses=Course::where('name',$courseName)->get();
			if(count($courses)<=0)
			{
				abort(404);
			}
		}
		else{
			$courses=Course::all();
		}   
		return view('backend.Project.create',['courses'=>$courses]);
	}

	public function createProject(Request $request)
	{     
		try{
			$Project=Project::create([
				'link'=>$request['link'],
				'name'=>$request['name'],
				'course_id'=>$request['course_id'],
				'admin_id'=>Auth::user()->id,
				'type'=>$request['type'],
				'level'=>$request['level'],
				'description'=>$request['description'],
				'playlist'=>$request['playlist'],
			]);

			if($request->file('backImage'))
			{
				$fileName = time().'.'.$request->file('backImage')->extension();  
				$request->file('backImage')->move(public_path('uploads/projects'), $fileName);
				$Project->image_url=$fileName;

			}
			$Project->save();

		}
		catch(Exception $e){
			Log::error("Error in creating Project ".$e);          
		}
		return redirect('/admin/project/all');  
	}

	public function showEditProject($id)
	{
		$courses=Course::all();
		$Project=Project::find($id);
		return view('backend.Project.edit',['Project'=>$Project, 'courses'=>$courses]);
	}

	public function saveEditProject(Request $request, $id)
	{
		try
		{
			$Project=Project::find($id);
			if($Project!=null)
			{
				if($request->file('backImage'))
				{ 
					$fileName = time().'.'.$request->file('backImage')->extension();  
					$request->file('backImage')->move(public_path('uploads/projects'), $fileName);
					$Project->image_url=$fileName;
				}
				$Project->playlist=$request['playlist'];
				$Project->description=$request['description'];
				$Project->name=$request['name'];
				$Project->link=$request['link'];
				$Project->level=$request['level'];
				$Project->type=$request['type'];
				$Project->course_id=$request['course_id'];
				$Project->admin_id=Auth::user()->id;
				$Project->save();
			}
			else{
				abort(404);
			}
		}
		catch(Exception $e){
			Log::error("Error in saving Project".$e);    
		}
		return redirect('admin/project/all');
	}

	public function showAllProject($course_name='')
	{

		if($course_name=='')
		{
			$Project=Project::with('Course')->get();
			return view('backend.Project.all',['Project'=>$Project]);  
		}
		else{
			$course=Course::where('name',$course_name)->first();
			if($course!=null)
			{
				$Project=Project::where('course_id',$course['id'])->get();
				return view('backend.Project.show',['course'=>$course,'Project'=>$Project]);
			}
			else{
				abort(404);
			}
		}
	}

	public function deleteProject(Request $request)
	{
		$id=$request['id'];
		$name=$request['title'];
		$success=Project::find($id)->delete();
		if($success!=null)
		{
			Session::flash("success","You have Successfully Deleted ".$name);
			return redirect()->back();
		}

	}

	/**
	 * @OA\Post(
	 *     path="/api/get-projects",
	 *     tags={"Projects"},
	 *     description="Get all projects of a particular course",
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
	 *          description="course_id of Course ",
	 *          required=true,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *     ),
	 *     @OA\Parameter(
	 *          name="level",
	 *          in="query",
	 *          description="Level of projects : easy|medium|hard",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="count",
	 *          in="query",
	 *          description="Count of projects,If not passed by default value of count is 10",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *     @OA\Parameter(
	 *          name="page",
	 *          in="query",
	 *          description="page no  of projects,If not passed by default value of page is 1",
	 *          required=false,
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *    @OA\Response(
		 *          response=200,
		 *      description="{[error_code=>0,msg=>'success'],[error_code=>1,msg=>'Course Id is Invalid'],[error_code=>2,'msg'=>'Course Id is Compulsory']}"
		 *     )
		 * )
		 */
	
	public function wsGetAllProjects(Request $request){
		if(isset($request['course_id'])){
			$course=Course::find($request['course_id']);
			if($course!=null){
				$level=isset($request['level'])?$request['level']:'';
				$count= isset($request['count'])?$request['count']:'10';
				if($level=='')
				{
					$Project=Project::withCount(['ResourceProjectLikes as like'=>function($query){
						$query->where('user_id',JWTAuth::user()->id);
					}])->withCount('ResourceProjectLikes as total_likes')
					->withCount(['ResourceProjectViews as view'=>function($query){
						$query->where('user_id',JWTAuth::user()->id);
					}])->withCount('ResourceProjectViews as total_views')
					->where('course_id',$request['course_id'])
					->paginate($count);
					
					return response()->json(['error_code'=>0,'Project'=>$Project]);
				}
				else{
					
					$Project=Project::withCount(['ResourceProjectLikes as like'=>function($query){
						$query->where('user_id',JWTAuth::user()->id);
					}])->withCount('ResourceProjectLikes as total_likes')
					->withCount(['ResourceProjectViews as view'=>function($query){
						$query->where('user_id',JWTAuth::user()->id);
					}])->withCount('ResourceProjectViews as total_views')
					->where('course_id',$request['course_id'])
					->where('level',$level)
					->paginate($count);

					return response()->json(['error_code'=>0,'Project'=>$Project]);
				}
			}
			else{
				return response()->json(['error_code'=>1,'msg'=>'Course Id is Invalid']);
			}
		}
		else{
			return response()->json(['error_code'=>2,'msg'=>'Course Id is Compulsory']);
		}

	}

	/**
   * @OA\Post(
   *     path="/api/get-suggested-projects",
   *     tags={"Projects"},
   *     description="Get all projects suggested for a particular user",
   *     @OA\Parameter(
   *          name="token",
   *          in="query",
   *          description="token",
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
	public function wsGetAllSuggestedProjects(Request $request){

		$user=JWTAuth::user();
      
	    if(!is_null($user->preferences)  && $user->preferences!='')
	    {
	        $preferences=explode(',', $user->preferences);
	        $course_name=$preferences['0'];
	        
	        $course=Course::where('name',$course_name)->where('status','publish')->first();
	        if($course==null){
	            $course_id=1;
	        }
	        else{
	        	$count=Project::where('course_id',$course->id)->count();
	        	if($count<3){
	        		$course_id=1;			
	        	}
	        	else{
	        		$course_id=$course->id;
	        	}
	        }
	    }
	    else{
	    	$course_id=1;
	    }

  		$project=Project::where('course_id',$course_id)->take(5)->get();
  		return response()->json(['success'=>true,'course_id'=>$course_id,'projects'=>$project]);
	}


   /**
   * @OA\Post(
   *     path="/api/project",
   *     tags={"Projects"},
   *     description="Get a project",
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
   *          description="project_id of Project ",
   *          required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *     ),
   *     @OA\Response(
   *          response=200,
   *      description="{[error_code=>0,msg=>'success'],[error_code=>1,msg=>'Project Id is Invalid'],[error_code=>2,'msg'=>'project Id is Compulsory']}"
   *     )
   * )
   */
   public function wsGetProject(Request $request){
      if(isset($request['project_id']))
      {
          $project=Project::find($request['project_id']);
          if($project!=null){
              return response()->json(['success'=>true,'error_code'=>0,'project'=>$project]); 
          }
          else{
              return response()->json(['success'=>false,'error_code'=>1,'message'=>'No project Available for this Id']);   
          }
      }
      else{
          return response()->json(['success'=>false,'error_code'=>2,'message'=>'project Id is Compulsory']); 
      }
   }

}
//end of class
