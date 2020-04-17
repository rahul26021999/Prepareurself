<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;

class JwtMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=>false,'message' => 'Token is Invalid'],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success'=>false,'message' => 'Token is Expired'],402);
            }else{
                return response()->json(['success'=>false,'message' => 'Authorization Token not found'],400);
            }
        }
        return $next($request);
    }
}
