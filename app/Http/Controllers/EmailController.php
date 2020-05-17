<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\CustomEmail;
use Mail;
use Session;

class EmailController extends Controller
{
	public function showEmail()
	{
		return view('backend.EmailNotification.show');
	}
	public function showCustomEmail(Request $request)
	{
		return view('backend.EmailNotification.custom-email');
	}
	public function saveCustomEmail(Request $request)
	{
		
	}

	public function sendCustomEmailToAll(Request $request)
	{
		$subject=$request['subject'];
		$body=$request['body'];

		$users = User::where('email_verified_at','!=',null)->get();
		foreach ($users as $user) {
            Mail::to($user)->queue(new CustomEmail($user,$subject,$body));
		}

		Session::flash('success','Successfully send Email to '.count($users).' Users!');
        return redirect()->back();
	}

	public function sendTestCustomEmail(Request $request)
	{
		$subject=$request['subject'];
		$body=$request['body'];

		$emails=array('rahul26021999@gmail.com','rahul9650ray@gmail.com','tanyagarg2509@gmail.com','rimjhimvaish@gmail.com');

		$users = User::whereIn('email',$emails)->get();
		// dd($users);
		foreach ($users as $user) {
            Mail::to($user)->send(new CustomEmail($user,$subject,$body));
		}
		
		Session::flash('success','Successfully send Email to all test users!');
        return redirect()->back();
	}


	public function sendVerificationEmails(Request $request){
		$users = User::where('email_verified_at',null)->get();
		foreach ($users as $user) {
            // Mail::to($user)->send(new );
		}
	}

	public function sendEmail(Request $request){

		if($request['type']=='newCourse')
		{
			$courseId=$request['courseId'];
			$title=$request['title'];

			$users = User::where('email_verified_at','!=',null)->get();
			foreach ($users as $user) {
	            Mail::to($user)->send(new NewCourseMail());
			}
		}
	}

}
