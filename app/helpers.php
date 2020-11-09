<?php

use Illuminate\Support\Facades\Route;

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