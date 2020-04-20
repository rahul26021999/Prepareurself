<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

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
        if(!$user->hasVerifiedEmail()){
            $user->sendEmailVerificationMail();
            return response()->json(['error'=>true,'error_code'=>1,'message'=>'Please Verify Your Email']);
        }

        return $next($request);
    }
}
