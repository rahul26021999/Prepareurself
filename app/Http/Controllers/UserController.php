<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exception;
use App\User;
use App\Models\ResourceProjectLikes;
use App\Models\ResourceProjectViews;
use App\Models\UserFeedback;
use Log;
use Session;

class UserController extends Controller
{
    public function showAllUsers($type='')
    {
    	if($type=='blocked'){
    		$users=User::where('user_status','blocked')->get();
    	}
    	else{
    		$users=User::all();
    	}
		return view('backend.users.show',['users'=>$users]);
    }

    public function deleteUser(Request $request)
    {
        $id=$request['id'];
        $user=User::find($id);
        if($user!=null)
            $user->delete();

        $likes=ResourceProjectLikes::where('user_id',$id)->delete();
        $views=ResourceProjectViews::where('user_id',$id)->delete();
        $userfeedback=Userfeedback::where('user_id',$id)->delete();

        Session::flash('success'," 1 User Deleted with ".$likes." likes, ". $views." views, ".$userfeedback." user Feedback are also deleted");
        return redirect()->route('admin.users.all');

    }
    public function showUser(Request $request,$id)
    {
        $user=User::find($id);
        return view('backend.users.details',['user'=>$user]);
    }
}
