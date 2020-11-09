<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    // 话题模型与分类模型的关系
    public function category()
    {
        // 一条话题只属于一种分类
        return $this->belongsTo(Category::class);
    }

    // 话题模型与用户模型的关系
    public function user()
    {
        // 一条话题只属于一个用户
        return $this->belongsTo(User::class);
    }
}
