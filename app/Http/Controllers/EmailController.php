<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\CustomEmail;
use Mail;

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

	public function sendCustomEmail(Request $request)
	{
		$subject=$request['subject'];
		$body=$request['body'];

		// $users = User::where('email_verified_at','!=',null)->get();
		// foreach ($users as $user) {
  //           Mail::to($user)->send(new CustomEmail($user,$subject,$body));
		// }

		$user = User::where('email','rahul26021999@gmail.com')->get();
		Mail::to($user)->send(new CustomEmail($user,$subject,$body));
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
