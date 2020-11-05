<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户数据，包括上传图片的逻辑
     */
    public function update(UserRequest $request, ImageUploadHandler $upLoader, User $user)
    {
        // 获取表单送来的全部数据
        $data = $request->all();

        // 图片上传逻辑
        if ($request->avatar) {
            // 第四个参数为头像图片的裁剪尺寸
            $result = $upLoader->save($request->avatar, 'avatar', $user->id, 416);
            // 如果图片上传成功，更新 $data['avatar']
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        // 不论图片是否上传成功，更新数据
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }


}
