<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Log;
use Mail;
use Auth;
use App\Models\Resource;
use App\Models\Project;
use App\Mail\RegisterSuccessful;
use Illuminate\Support\Facades\Hash;
use Exception;
use Session;
use JWTAuth;

class AdminUserController extends Controller
{

    public function index()
    {
        $verifiedUser=User::where('email_verified_at','!=',null)->count();
        $totalUser=User::all()->count();
        $preferencedUsers=User::where('preferences','!=',null)->count();
        $notificationTokenFound=User::where('android_token','!=',null)->count();

        $firstUser=User::first();
        $token = JWTAuth::fromUser($firstUser);

        $total_resources=Resource::all()->count();
        $total_projects=Project::all()->count();
        
        return view('backend.dashboard',[
            'total_user'=>$totalUser,
            'verified_user'=>$verifiedUser,
            'preferenced_user'=>$preferencedUsers,
            'token_user'=>$notificationTokenFound,
            'total_resources'=>$total_resources,
            'total_projects'=>$total_projects,
            'JWTtoken'=>$token,
        ]);
    }
    public function showLogin()
    {
        return view('backend.auth.login');
    }
    public function login(Request $request)
    {
        if(Auth::guard('admin')->attempt($request->only('email','password'))){

            Session::flash('success','You are Logged in as Admin!');
            return redirect(route('admin.home'));                
        }
        else{
            Session::flash('error','Invalid Admin Credentials!');
            return redirect()->back();
        }
    }
    public function showRegister()
    {
        return view('backend.auth.register');
    }
    public function register(Request $request)
    {
        try{
            $email=$request['email'];
            $user =Admin::where('email', $email)->first();
            if($user!=null)
            {
                $user->first_name=$request['firstName'];
                $user->last_name=$request['lastName'];
                $user->password=Hash::make($request['password']);
                $user->save();

                Session::flash('success','Admin Registeration Success Please Login !');
                return redirect(route('admin.auth.login'));
            }
            else{
                Session::flash('error','You are not Authorised as Admin !');
                return redirect()->back();
            }
        }
        catch(Exception $re)
        {
            Session::flash('error','Something Went Wrong please contact Adminstrator!');
            Log::error("Registration error of Admin page".$re);
            return redirect()->back();
        }
      
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flash('success','Admin has been logged out!');
        return redirect()->route('admin.auth.login');            
    }
    public function manage()
    {
        $admins=Admin::all();
        return view('backend.manage.all_admin',['admins'=>$admins]);
    }
    public function createAdmin(Request $request){
        $email=$request['email'];
         $admin=Admin::create([
            'email'=>$email
        ]);
        Session::flash('success',$email.' is Added As Admin!');
        return redirect()->back();
    }

    public function showForgotPassword()
    {
        return view('backend.auth.forgot');
    }
    public function forgotPassword(Request $request)
    {
        $email=$request['email'];
        $user =Admin::where('email', $email)->first();
        if($user!=null)
        {
            $user->sendForgotPasswordMail();
            Session::flash('success','hey '.$user->first_name.'! Please Check Your Mail to Reset your Password');
            return redirect()->back();
        }
        else{
            Session::flash('error','You are not Authorised as Admin !');
            return redirect()->back();
        }
    }
    public function showResetPassword(Request $request)
    {
        return view('backend.auth.resetPassword',['id'=>$request['id'],'type'=>$request['type']]);   
    }

    public function resetPassword(Request $request)
    {
        $type=base64_decode($request['type']);
        $id=base64_decode($request['id']);
        if($type=="Admin"){
            $user=Admin::find($id);
        }
        else{
            $user=User::find($id);
        }

        $user->password=Hash::make($request['password']);
        $user->save();
        $user->sendPasswordUpdateMail();
        
        Session::flash('success',"Password Updated Successfully Please Login to Continue!");
        
        if($type=='Admin')
            return redirect()->route('admin.auth.login');    
        else
            return view('frontend.share.app',['type'=>'home']);

    }

    public function verifyEmail(Request $request)
    {
        $id=base64_decode($request['id']);
        $user=User::find($id);
        if(!$user->hasVerifiedEmail())
            $user->markEmailAsVerified();
        
        return redirect('install');

    }

}
