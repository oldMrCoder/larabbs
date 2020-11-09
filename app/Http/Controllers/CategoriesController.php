<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = Topic::where('category_id', $category->id)->paginate(20);

        // 传参变量话题和分类到模板中
        // 与未分类的话题页面使用同一个 view ，只是这里的 $topics 已是同一分类的话题
        return view('topics.index', compact('topics', 'category'));
    }
}
