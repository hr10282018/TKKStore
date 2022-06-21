<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Comment;
use App\Models\Good;
use App\Models\User;
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

  public function goods_detail_comment(Request $request,Comment $comment, $goods_id) // 用户评论商品
  {   
  

    $is_delete=Good::where('id',$goods_id)->exists();
    if(!$is_delete){
      // throw new \Exception('此商品不存在！');
      throw new InvalidRequestException('抱歉，此商品已被删除！');
      
    }

   
    $credentials = $this->validate($request, [
      'content' => ['required', 'max:255'],
    
    ], [
      'content.max' => '最多填写255个字符！',
    ]);
    
    $comment->content = $request->content;

    $comment->user_id = Auth::id();
    $comment->goods_id = $goods_id;
    $comment->save();

    Good::where('id',$goods_id)->increment('reply_count');

    return redirect()->back()->with('success', '评论发表成功！');
  }

  public function delete_comment(Good $goods_id,Comment $comments_id){     // 删除评论
    
    // $good=Good::where('id',$goods_id)->exists();
    // if(!$good){
    //   throw new InvalidRequestException('抱歉，此商品已被删除！',404);
    // }

    // $comment=Comment::where('id',$comments_id)->exists();
    // if(!$comment){
    //   throw new InvalidRequestException('抱歉，此评论已被删除！',404);
    // }
    
    $comments_id->delete();
    //Comment::destroy($comments_id);

    $goods_id->decrement('reply_count');  // -1

    return [];
  }

  // 搜索
  public function search_comment(User $user,Request $request){

    $search='%' . $request->content . '%';
    //dd($search);
    $comments=Comment::where('content','like',$search)->orderBy('created_at', 'desc');

    $count = $comments->count();
    //dd($count);
    $comments = $comments->with('goods')->paginate(5);

    // 可见数据
    $user_visible = $user->userVisibles;

    return view('users.detail._user_comments', compact('user', 'comments', 'count', 'user_visible'));
   
  }

}
