<?php

namespace App\Http\Controllers;


use App\User;
use App\Models\PermissionRole;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = User::find(Auth::id());

        $role_ids = array_column($user->roles->toArray(),'id');//获取角色
        $permissions = PermissionRole::instance()->whereIn('role_id',$role_ids)->get()->toArray();//获取权限
        $permission_id = array_column($permissions,'permission_id');
        $menu = [];
        if (!empty($permission_id)) {
            $permission = Permission::instance()
                ->whereIn("id", $permission_id)
                ->orderBy("sort", "asc")
                ->get();

            foreach ($permission as $k => $v) {
                if ($v->parent_id == 0) {
                    $menu[$v->id]['id'] = $v->id;
                    $menu[$v->id]['display_name'] = $v->display_name;
                    $menu[$v->id]['url'] = str_replace('_', '/', $v->name);
                    $menu[$v->id]['class_name'] = $v->class_name;
                    foreach ($permission as $key => $vel) {
                        if ($vel->parent_id == $v->id) {
                            $menu[$v->id]['seed'][$vel->id]['id'] = $vel->id;
                            $menu[$v->id]['seed'][$vel->id]['display_name'] = $vel->display_name;
                            $menu[$v->id]['seed'][$vel->id]['url'] = str_replace('_', '/', $vel->name);
                            $menu[$v->id]['seed'][$vel->id]['class_name'] = $vel->class_name;
                        }
                    }
                }
            }
        }

        return view('admin.index.index',['menu'=>$menu]);
    }
}
