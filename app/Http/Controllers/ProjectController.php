<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Course;
use Log;
use App\Exception;
use Session;
use Auth;


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
		return redirect('/admin/Project/all');  
	}

	public function showEditProject($id)
	{
		$Project=Project::find($id);
		return view('backend.Project.edit',['Project'=>$Project]);
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
		return redirect('admin/Project/all');
	}

	public function showAllProject($course_name='')
	{

		if($course_name=='')
		{
			$Project=Project::with('Course')->get();
			// echo $Project;
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
		$name=$request['name'];
		Project::find($id)->delete();
		Session::flash("success","You have Successfully Deleted ".$name);
		return redirect()->back();
	}

}
//end of class
