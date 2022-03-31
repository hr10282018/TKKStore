<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Good;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      'only'  =>  ['goods_detail_comment','delete_comment']
    ]);
  }

  public function goods_detail_comment(Request $request,Comment $comment, Good $goods_id){   // 用户评论商品
    //dd($request->all());
    //dd($goods_id->id);
    $comment->content = $request->content;
    $comment->user_id = Auth::id();
    $comment->goods_id = $goods_id->id;
    $comment->save();

    Good::where('id',$goods_id->id)->increment('reply_count');

    return redirect()->back()->with('success', '评论发表成功！');
  }

  public function delete_comment($goods_id,$comments_id){     // 删除评论
    //dd($request->goods_id);
    
    Comment::destroy($comments_id);
    Good::where('id',$goods_id)->decrement('reply_count');  // -1

    return [];
  }

}
