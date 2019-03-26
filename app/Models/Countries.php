<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/24
 * Time: 14:43
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Countries extends Model
{
    protected $table = 'countries';


    public function posts()
    {
        return $this->hasManyThrough('App\Models\Posts', 'App\User');
    }
}