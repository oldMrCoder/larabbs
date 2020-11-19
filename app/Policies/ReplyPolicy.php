<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        // 当前操作用户是回复的所有者，或当前操作用户是帖子的所有者
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
