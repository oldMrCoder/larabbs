<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;

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

		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
	}

	// 上传在话题编辑器中上传图片
	public function uploadImage(Request $request, ImageUploadHandler $uploader)
	{
		// 初始化返回数据，默认是失败的
		$data = [
			'success' => false,
			'msg' => '上传失败！',
			'file_path' => ''
		];
		// 判断是否有上传文件，并赋值给 $file
		if ($file = $request->upload_file) {
			// 保存图片到本地，使用的是自定义的 ImageUploadHandler 类，位置：app/handlers/
			$result = $uploader->save($file, 'topics', Auth::id(), 1024);
			// 图片保存成功的话
			if ($result) {
				$data['file_path'] = $result['path'];
				$data['msg'] = "上传成功！";
				$data['success'] = true;
			}
		}
		return $data;
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