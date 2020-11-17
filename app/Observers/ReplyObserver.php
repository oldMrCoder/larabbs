<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // 对回复内容过滤，禁止可进行 XSS 的标签通过
        // 扩展包：HTTPpurifier
        // 配置位置：config\purifier.php
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    public function updating(Reply $reply)
    {
        //
    }
}