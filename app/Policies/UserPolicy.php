<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    //参数1未当前用户；参数2是要授权的用户(url中的)
    public function update_user_info(User $currentUser, User $user) // 判断是否一致
    {
      return $currentUser->id === $user->id;
    }
}
