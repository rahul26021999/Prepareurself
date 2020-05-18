<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Email;
use App\Mail\CustomEmail;
use Mail;
use Auth;
use Session;

class EmailController extends Controller
{
	public function showEmail()
	{
		return view('backend.EmailNotification.show');
	}
	
	public function showComposeEmail(Request $request,$id='')
	{
		$emails=Email::all();
		if($id!=''){
			$email=Email::where('id',$id)->first();
			return view('backend.EmailNotification.custom-email',['emails'=>$emails,'email'=>$email]);
		}
		else{
			return view('backend.EmailNotification.custom-email',['emails'=>$emails]);
		}
	}
	public function createEmail(Request $request)
	{
		return Email::Create([
			'type'=>$request->input('type','sent'),
			'body'=>$request['body'],
			'subject'=>$request['subject'],
			'from'=>$request->input('from','noreply@prepareurself.in'),
			'to'=>$request->input('to',null),
			'admin_id'=>Auth::user()->id,
		]);
	}
	public function saveEmail(Request $request)
	{
		return Email::where('id',$request['id'])
					->update([
						'body'=>$request['body'],
						'subject'=>$request['subject'],
						'to'=>$request->input('to',null),
						'admin_id'=>Auth::user()->id,
					]);
	}
	public function saveCustomEmail(Request $request)
	{
		if($request['type']=='draft'){
			$email=$this->saveEmail($request);
		}
		else{
			$request['type']='draft';
			$email=$this->createEmail($request);
		}

		Session::flash('success','Email Successfully saved');
		return redirect()->back();
	}

	public function sendCustomEmailToAll(Request $request)
	{
		$subject=$request['subject'];
		$body=$request['body'];

		$users = User::where('email_verified_at','!=',null)->get();
		foreach ($users as $user) {
            Mail::to($user)->queue(new CustomEmail($user,$subject,$body));
		}

		$request['to']=implode(",",$users->pluck('email')->toArray());
		$email=$this->createEmail($request);

		Session::flash('success','Successfully send Email to '.count($users).' Users!');
        return redirect()->back();
	}

	public function sendTestCustomEmail(Request $request)
	{
		$subject=$request['subject'];
		$body=$request['body'];

		$emails=array('rahul26021999@gmail.com','rahul9650ray@gmail.com','tanyagarg2509@gmail.com','rimjhimvaish@gmail.com');
		
		$users = User::whereIn('email',$emails)->get();
		foreach ($users as $user) {
            Mail::to($user)->send(new CustomEmail($user,$subject,$body));
		}

		$request['to']=implode(",",$users->pluck('email')->toArray());
		$email=$this->createEmail($request);
		
		Session::flash('success','Successfully send Email to all test users!');
        return redirect()->back();
	}

}
