<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    /**
     * 获得拥有此评论的模型。
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
