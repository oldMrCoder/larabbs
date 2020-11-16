<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    public function topic()
    {
        // 一条回复只属于一个帖子
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        // 一条回复只属于一个用户
        return $this->belongTo(User::class);
    }
}
