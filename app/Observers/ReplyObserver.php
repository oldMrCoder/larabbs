<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

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
        // 更新帖子回复计数
        $reply->topic->updateReplyCount();
        // 通知话题作者有新的评论
        // 在 user.php 中重写 notify 方法，此处与教程不同，参照的是教程对应章节以面的一个同学回复
        $reply->topic->user->topicNotify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        // 更新帖子回复计数
        $reply->topic->updateReplyCount();
    }

    public function updating(Reply $reply)
    {
        //
    }
}