<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    //
    }

    // 添加授权策略：只有同一个用户才能通过
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
