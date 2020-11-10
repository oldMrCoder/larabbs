<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 分类话题列表辅助函数
// 需要先安装扩展包 summerblue/laravel-active:7.*
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

// 帖子摘要提取方法
function make_excerpt($value, $lenght = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $lenght);
}