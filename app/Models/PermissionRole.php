<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 18:13
 */

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

    private static $instance;
    protected $table = 'permission_role';
    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }
}