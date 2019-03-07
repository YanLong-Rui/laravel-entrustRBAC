<?php
/**
 * Created by PhpStorm.
 * User: 栾军
 * Date: 2017/11/7
 * Time: 16:27
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $primaryKey = ['user_id', 'role_id'];

    public $timestamps = false;
    public $incrementing = false;

    private static $instance;

    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function getRoleByUID($user_id)
    {
        return self::where("user_id", $user_id)->first();
    }

    public function Users()
    {
        // 对应的model类 ， user表的主键id  role_user本地键user_id
        return $this->hasOne('App\User','id','user_id');
    }

    public function Modify($role_id)
    {
        echo $role_id;die;
    }
}