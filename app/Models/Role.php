<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 18:13
 */

namespace App\Models;



use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    private static $instance;

    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }
}