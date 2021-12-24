<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\User;
use App\Policies\GoodPolicy;
use Auth;
use Carbon\Carbon;

class GoodsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      //
      'except' => ['goods_search']
    ]);
  }

  /* 发布商品 */
  public function create_goods()
  {
    return view('goods.create_goods');
  }
  public function create_goods_check(Request $request, Good $good, ImageUploadHandler $uploader)
  {   //处理发布商品
    //dd($request->all());
    $goods = $request->all();
    $goods['image'] = '';

    for ($i = 0; $i < sizeof($goods['goods_img']); $i++) {
      $true = $uploader->save($goods['goods_img'][$i], 'avatars', Auth::user()->id, 416);
      if ($true) {
        $goods['image'] = $goods['image'] . $true['path'] . ',';
      } else {
        session()->flash('warning', '修改失败！请上传 png、gif、jpg、jpeg 格式的图片');
        return redirect()->route('create_goods');
      }
    }
    $goods['user_id'] = Auth::user()->id;   // 用户id
    $goods['state'] = '1';      // 1-商品发布且正在售卖
    $goods['category_id'] = Category::where('name', $goods['category_id'])->first()->id;  // 分类id

    $good->fill($goods);
    $good->save();

    return redirect()->route('home')->with('success', '商品发布成功！');
  }


  /* 商品详情 */


  /* 商品查询 */
  public function goods_search(Request $request, Good $good, Category $category)
  {
    //dd($request->input('category_id', ''));
    $builder=Good::query();

    if ($category_id = $request->input('category_id', '')) {

      $categories = Category::where('id', $category_id)->first();
      $builder->where('category_id', $category_id);
    }
    if($key=$request->input('key', '')){    // 最新发布
      $builder ->where('created_at', '>=', Carbon::now()->subWeeks('4'));
    }

    if ($search = $request->input('search', '')) {
      $like = '%' . $search . '%';
      $builder->where(function ($query) use ($like) {
        $query->where('title', 'like', $like)
              ->orWhere('description', 'like', $like);
      });
    }
    if ($state = $request->input('state', '')) {
      $builder->where('state', $state);
    }
    if ($order = $request->input('order', '')) {
      if($order=='1'){
         $builder->orderBy('price', 'asc');
      }elseif($order=='2'){
         $builder->orderBy('price', 'desc');
      }elseif($order=='3'){
         $builder->orderBy('created_at', 'asc');
      }else{
         $builder->orderBy('created_at', 'desc');
      }

    }

    $goods = $builder->paginate(12);
    if(isset($categories)){     // 有分类必须再返回分类数据
      return view('pages.root', compact('goods','categories','search','order','state'));
    }
    return view('pages.root', compact('goods','search','order','state'));
  }

  /* 商品详情 */
  public function goods_detail($goods_id){


    $goods_info=Good::where('id',$goods_id)->first();
    $length=substr_count( $goods_info->image,',');

    $images=explode(',',$goods_info->image);
    $user=User::where('id',$goods_info->user_id)->first();

    $comments=Comment::where('goods_id',$goods_id)->get();

    //dd($comments);
    //GoodPolicy::

    return view('goods.detail',compact('comments'),compact('images','length','goods_info','user'));

  }

}
