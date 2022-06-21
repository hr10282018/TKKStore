<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Good;


class PagesController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      'except' => ['root', 'category_show']
    ]);
  }

  // 主页
  public function root(Request $request)
  {
    //session()->forget('primary');
    //dd($request->session());

    $goods = Good::where('state', Good::goods_state_in_selling)->orderBy('created_at', 'desc')->paginate(16);
    
   
    // dd($goods);
    return view('pages.root', compact('goods'));
  }

  /* 分类 */
  public function category_show($category_id, Request $request, Category $category, Good $good)
  {
    $categories = Category::where('id', $category_id)->first();

    $goods = $good->where('category_id', $category_id)->where('state', Good::goods_state_in_selling)->orderBy('created_at', 'desc')->paginate(16);

   
    return view('pages.root', compact('goods', 'categories'));
  }

}
