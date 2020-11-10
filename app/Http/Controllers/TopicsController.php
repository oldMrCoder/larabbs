<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
		// 对于帖子类的操作，除了 index，show 以外，其它都有通过 auth 认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		// withOrder() 为自定义的查询方法，用于话题排序，为于 Topic.php 
		// 预加载 user , category 两个数据表，修复 N+1 问题，即减少对数据库的查询次数
		$topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		// store() 方法第二个参数会创建一个空白的 Topic 实例
		// 用 $request 提取表单送来的全部参数
		// 填入 $topic 的对应字段中 
		$topic->fill($request->all());
		// 手动填入 user_id 
		$topic->user_id = Auth::id();
		$topic->save();

		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功A');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}