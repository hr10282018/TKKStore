<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Good;
use Carbon\Carbon;
use Auth;

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
    $goods = Good::where('state', '2')->orderBy('created_at', 'desc')->paginate(16);
    
    // $images = $goods->pluck('image');
    // for ($i = 0; $i < sizeof($images); $i++) {
    //   $images[$i] = explode(',', $images[$i])[0];
    // }
    //$goods = $goods->paginate(2);
    //dd($images);
    return view('pages.root', compact('goods'));
  }

  /* 分类 */
  public function category_show($category_id, Request $request, Category $category, Good $good)
  {
    $categories = Category::where('id', $category_id)->first();

    $goods = $good->where('category_id', $category_id)->where('state', '2')->orderBy('created_at', 'desc')->paginate(16);
    // if(session()->get('primary')){
    //   session()->forget('primary');
    // }else{
    //   session()->flash('primary', $categories->description);
    // }
    return view('pages.root', compact('goods', 'categories'));
  }

}
