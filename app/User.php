<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\PermissionRole;
use App\Models\Permission;
class User extends Authenticatable
{



    private static $instance;
    public $timestamps = true;
    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }
    use Notifiable;
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获得用户的角色。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','role_user', 'user_id', 'role_id');
    }

    /**
     * @param $user_id
     */
    public function getMenu($user_id)
    {
        $user = User::find($user_id);
        $role_ids = array_column($user->roles->toArray(), 'id');//获取角色
        $permission_id = PermissionRole::instance()->whereIn('role_id', $role_ids)->pluck('permission_id');//获取权限
        //$permission_id = array_column($permissions, 'permission_id');
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
        return $menu;
    }
}
