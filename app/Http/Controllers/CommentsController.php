<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      
    ]);
  }

  public function goods_detail_comment(Request $request,Comment $comment){   // 用户评论商品
    //dd($request->all());
    $comment->content = $request->content;
    $comment->user_id = Auth::id();
    $comment->goods_id = $request->goods_id;
    $comment->save();

    return redirect()->back()->with('success', '评论发表成功！');
  }

  public function delete_comment(Comment $comment,$goods_id){     // 删除评论
    //dd($goods_id);
    Comment::destroy($goods_id);

    return redirect()->back()->with('success', '评论删除成功！');
  }

}
