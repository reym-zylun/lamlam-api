<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\BeforeMiddleware;
use Route;
use App\User;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        if (Auth::guard('api')->guest()) {
            return response()->json(['message'  => "Unauthorized."],401);
        } else {
            if (Auth::check())
            {
                $access_token = Auth::guard('api')->user();
                if (Route::getCurrentRoute()->getName() != 'auth.refresh' &&
                    strtotime($access_token->expired_date) < time()) {
                    return response()->json(['message'  => "Unauthorized."],401);
                }
                $middleware = new BeforeMiddleware();
                if ($middleware->api_client($request)->id != $access_token->api_client_id) {
                    return response()->json(['message'  => "Unauthorized."],401);
                }
                $user = User::find($access_token->user_id); 
                if($guard == "admin" && $user->role != "admin"){
                    return response()->json(['message'  => "Unauthorized."],401);
                }

                if (!is_null($request->route('id'))) {
                    if ($access_token->user_id != $request->route('id') && $user->role != 'admin') {
                        return response()->json(['message'  => "Unauthorized."],401);
                    }
                }
                return $next($request);
            }
        }
        return response()->json(['message'  => "Unauthorized."],401);
    }
}

