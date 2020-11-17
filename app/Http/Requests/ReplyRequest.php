<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    // 回复的验证规则
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
