<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Log;

class UserEmailVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=JWTAuth::user();
        if(!is_null($user)){
            if(!$user->hasVerifiedEmail()){
                $user->sendEmailVerificationMail();
                return response()->json(['error'=>true,'error_code'=>1,'message'=>'Please Verify Your Email']);
            }
        }
        else{
            Log::alert("Middleware : EmailVerificattion");
        }

        return $next($request);
    }
}
