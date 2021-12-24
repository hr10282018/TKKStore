<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Good;

class GoodPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    // 用户编辑自己的商品
    public function eidt_goods(User $currentUser,Good $good){
      return $currentUser->id !== $good->user_id;
    }
}
