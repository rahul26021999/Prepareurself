<?php

namespace App\Http\Middleware;

use Closure;

class BotMiddleware
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
        if($request->filled('token')){
           if($request['token']!=env('BOT_SECRET')) {
                return response()->json(["message"=>"Invalid Access","error_code"=>2]);
           }
        }
        else{
            return response()->json(["message"=>"UnAuthorised Access","error_code"=>1]);
        }
        return $next($request);
    }
}
