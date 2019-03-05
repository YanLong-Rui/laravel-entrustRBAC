<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckAuth
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
        if(Auth::check() == false){
            return redirect('login');
        }
        $user = Auth::user();
        if($user){
            return $next($request);
        }
        echo '登录已过期，请重新登录!';die;
    }
}
