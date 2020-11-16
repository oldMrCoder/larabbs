<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

// Eloquent 类事件观察器，当该类实体的事件触发时，例如：creating created saving 等等，本观察器将调用与事件同名的方法
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

    public function saving(Topic $topic)
    {
        // 过滤可以进行 XSS 攻击的高危标签
        // 因为页面渲染时，blade 的 {{ }} 已有过滤功能，而 {!! !!} 并没有，
        // 而 $topic->body 的渲染正使用了 {!! !!}
        $topic->body = clean($topic->body, 'user_topic_body');

        // make_excerpt() 为自定义辅助方法，用于从帖子内容中提取摘要，方法位置：helpers.php
        $topic->excerpt = make_excerpt($topic->body);

        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            // app 直接创建 SlugTranslateHandler 实例
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}