<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Good;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class CommentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    // 删除评论
    public function delete_comment(User $currentUser, Comment $comment){
      // 评论的作者可以删除 + 商品的作者可以删除
      return ($currentUser->id === $comment->user_id) ||  ($comment->goods->user_id === $currentUser->id) ;
    }
}
