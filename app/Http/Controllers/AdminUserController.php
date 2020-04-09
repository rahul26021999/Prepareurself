<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Log;
use Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

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
            //Authentication passed...
            return redirect(route('admin.home'))
                ->with('status','You are Logged in as Admin!');
        }
        else{
            return redirect(route('admin.auth.login'))
            ->with('status','Invalid Admin Credentials!');
        }
    }
    public function showRegister()
    {
        return view('backend.auth.register');
    }
    public function register(Request $request)
    {
        try{
            $user=Admin::where('email',$request->only('email'))->first()->get();
            if($user!=null)
            {
                $user->first_name=$request['first_name'];
                $user->last_name=$request['last_name'];
                $user->password=Hash::make($request['password']);
                $user->save();
                return redirect(route('admin.auth.login'))
            }
            else{
                return redirect(route('admin.auth.login'))
            }
        }
        catch(Exception $re)
        {
            Log::error("Registration error of Admin page");
            return redirect(route('admin.auth.login'))
        }
      
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.auth.login')
            ->with('status','Admin has been logged out!');
    }
    public function manage()
    {
        $admins=Admin::all();
        return view('backend.manage.all_admin',['admins'=>$admins]);
    }
    public function createAdmin(){
        $email=$request->only('email');
        $name=$request->only('first_name');
        $admin=Admin::create([
            'email'=>$email,
            'first_name'=>$name
        ]);
    }

}
