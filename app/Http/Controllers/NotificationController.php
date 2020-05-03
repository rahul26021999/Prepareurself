<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Traits\OneSingleNotification;

class NotificationController extends Controller
{
	use OneSingleNotification;

  	public function showNotification(){

     	return view('backend.notification.show');
    }

    public function sendTestNotification(Request $request)
    {
    	if($request->filled('title') && $request->filled('message') && $request->filled('screen'))
    	{
    		$title=$request['title'];
    		$message=$request['message'];
    		$image=$request->input('image','');

	    	$url=$this->generateAndroidClickLink($request);

	    	$userToken=array("77b918c7-28ed-4a38-9bbd-2b59a31f135b","b0fa55bd-b61e-41fd-b382-69ada116de5d","5866c59f-106d-4806-8386-6b3c8af59c85","114ea7ce-b753-437a-9d35-d673010ceacd");
    	
	    	if(count($userToken)>0)
	    	{
	    		$response=$this->sendToMany($title,$message,$image,$userToken,$url);
			   
	    		return response()->json([
	    			'success'=>true,
	    			"message"=>"Successfully sent notification to 3 Test Users",
	    			"response"=>$response
	    		]);
	    	}
    	}
    	else{
    		return response()->json([
    			'success'=>false,
    			'message'=>"Title and message cant be empty"
    		]);
    	}
    }

    public function sendAndroidNotification(Request $request)
    {
    	if($request->filled('title') && $request->filled('message') && $request->filled('screen'))
    	{
    		$title=$request['title'];
    		$message=$request['message'];
    		$image=$request->input('image','');

            $url=$this->generateAndroidClickLink($request);

	    	$userToken=User::where('android_token','!=',null)->get()->pluck('android_token')->toArray();
	    	if(count($userToken)>0)
	    	{
	    		$response=$this->sendToMany($title,$message,$image,$userToken,$url);
	    		return response()->json([
	    			'success'=>true,
	    			"message"=>"Successfully sent notification to ".count($userToken)." Users",
	    			"response"=>$response
	    		]);
	    	}
    	}
    	else{
    		return response()->json([
    			'success'=>false,
    			'message'=>"Title and message cant be empty"
    		]);
    	}
    }

    public function sendVerificationEmails(Request $request){
        $users = User::where('email_verified_at',null)->get();
        foreach ($users as $user) {
            // Mail::to($user)->send(new );
        }
    }

    public function sendEmails(Request $request){

    	$users = User::where('email_verified_at','!=',null)->get();
        foreach ($users as $user) {
            // Mail::to($user)->send(new );
        }
    }
}	
