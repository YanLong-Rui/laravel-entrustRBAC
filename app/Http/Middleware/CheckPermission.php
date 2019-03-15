<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Tools\App;
class CheckPermission
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

        $action = Route::currentRouteName();//获取路由名字
        $user = Auth::user();
        if (!$user->can($action)) {
            if ($request->ajax()) {
                return App::alert(403, "您没有权限访问", "您没有权限访问");
            } else  {
                abort(403,'对不起，您无权访问该页面！');
            }
        }
        return $next($request);
    }
}
