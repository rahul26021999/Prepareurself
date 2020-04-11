<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Log;
use Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Session;

class AdminUserController extends Controller
{

    public function index()
    {
        return view('backend.dashboard');
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
            return redirect(route('admin.auth.login'));
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

                Session::flash('success','Admin  Registeration Success Please Login !');
                return redirect(route('admin.auth.login'));
            }
            else{
                Session::flash('error','You are not Authorised asdfkj skajd sakjdf ksadhk Admin !');
                return redirect(route('admin.auth.register'));
            }
        }
        catch(Exception $re)
        {
            Session::flash('error','Something Went Wrong please contact Adminstrator!');
            Log::error("Registration error of Admin page".$re);
            return redirect(route('admin.auth.register'));
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
        return redirect()->route('admin.manage');
    }

}
