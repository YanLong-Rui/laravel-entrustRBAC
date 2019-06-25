<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * 获得此视频的所有评论。
     */
    public function comments()
    {
        return $this->morphMany('App\Comments', 'commentable');
    }
}
