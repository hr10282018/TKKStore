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


  // 用户查看自己商品 (预发布、审核中)
  public function seller_goods_detail(User $currentUser, Good $good)
  {
    // dd($good);

    if ($currentUser->id != $good->user_id && ($good['state'] == Good::goods_state_in_release || $good['state'] == Good::goods_state_in_check)) {     // 非作者
      return false;
    }


    return true;
  }

  // 用户编辑自己的商品
  public function eidt_goods(User $currentUser, Good $goods_info)
  {

    if ($currentUser->id != $goods_info->user_id) {
      return false;
    }
    return true;
  }
}
