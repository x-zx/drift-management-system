<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OpenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $openid = $request->input('openid');

        if(!empty($openid)){
            $request->session()->put('openid',$openid);
        }
        
        return $next($request);
    }
}

