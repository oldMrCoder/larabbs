<?php

namespace App\Models;

class Topic extends Model
{
    // 使用代码成生器时，各字段会默认为《可修改》，需要慎重新重制那些段字可以被用户修改
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

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

    /**
     * 用于话题排序
     * 使用了 Laravel 本地作用域 。
     * 本地作用域允许我们定义通用的约束集合以便在应用中复用。
     * 要定义这样的一个作用域，只需简单在对应 Eloquent 模型方法前加上一个 scope 前缀，作用域总是返回 查询构建器。
     * 一旦定义了作用域，则可以在查询模型时调用作用域方法。在进行方法调用时不需要加上 scope 前缀。如以上代码中的 recent() 和 recentReplied()。
     */
    
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
            break;

            default:
                $query->recentReplied();
            break;
        }
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    // 重新并接 topics.show 的 URL
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
