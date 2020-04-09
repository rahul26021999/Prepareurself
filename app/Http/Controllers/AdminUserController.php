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
            $email=$request['email'];
            $user =Admin::where('email', $email)->first();
            if($user!=null)
            {
                $user->first_name=$request['firstName'];
                $user->last_name=$request['lastName'];
                $user->password=Hash::make($request['password']);
                $user->save();

                return redirect(route('admin.auth.login'));
            }
            else{
                return redirect(route('admin.auth.register'));
            }
        }
        catch(Exception $re)
        {
            Log::error("Registration error of Admin page".$re);
            return redirect(route('admin.auth.register'));
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
