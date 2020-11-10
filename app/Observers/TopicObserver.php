<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    // Eloquent 类事件观察器，当该类实体的事件触发时，例如：creating created saving 等等，本观察器将调用与事件同名的方法
    public function saving(Topic $topic)
    {
        // make_excerpt() 为自定义辅助方法，用于从帖子内容中提取摘要，方法位置：helpers.php
        $topic->excerpt = make_excerpt($topic->body);
    }
}