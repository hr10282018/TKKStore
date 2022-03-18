<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\GoodInfoRequest;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\User;
use App\Policies\GoodPolicy;
use Auth;
use Carbon\Carbon;
use DB;
use App\Models\GoodTag;
use League\Flysystem\File;
use Cache;
use Doctrine\Common\Cache\Cache as CacheCache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redis;

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
  public function create_goods(GoodTag $good_tag)
  {
    $good_tag = GoodTag::get();
    //dd($good_tag);

    return view('goods.create_edit_goods', compact('good_tag'));
  }
  // 处理发布商品数据
  public function create_goods_check(Request $request, Good $good, ImageUploadHandler $uploader)
  {
    //dd($request->session());
    //dd($request->cookie());
    // dd($request->goods_old_img);
    // dd($request->goods_img);
    // 最小宽和高316和418-最大宽和高480和500

    //dd($request->all());

    $goods = $request->all();
    
    if ($goods['goods_old_img'] == null  && !isset($goods['goods_img'])) {
      //dd('你的图片未上传');
      session()->flash('null_data', '你还有未填的选项，无法提交！');
      return redirect()->back();
    } else {
      if (in_array(null, $goods)) {
        //dd('你还有未填的选项');
        session()->flash('null_data', '你还有未填的选项，无法提交！');
        return redirect()->back();
      }
    }

    $goods['image'] = '';
    if ($goods['goods_old_img']) {    // 编辑
      //dd('编辑');

      $goods['goods_old_img'] = explode(',', $goods['goods_old_img']);
      for ($i = 0; $i < sizeof($goods['goods_old_img']); $i++) {
        if ($goods['goods_old_img'][$i] == 'update') {
          $true = $uploader->save($goods['goods_img'][$i], 'goods', Auth::user()->id);      // 
          if ($true) {
            $goods['image'] = $goods['image'] . $true['path'] . ',';
          } else {
            session()->flash('wrong_type', '请选择 【GIF JPG JPEG PNG】 格式的图片！!');
            return redirect()->back();
          }
        } else {
          $goods['image'] = $goods['image'] . $goods['goods_old_img'][$i] . ',';
        }
      }
    } else {
      //dd('发布');                    // 创建
      for ($i = 0; $i < sizeof($goods['goods_img']); $i++) {
        $true = $uploader->save($goods['goods_img'][$i], 'goods', Auth::user()->id);      // 
        if ($true) {
          $goods['image'] = $goods['image'] . $true['path'] . ',';
        } else {
          session()->flash('wrong_type', '请选择 【GIF JPG JPEG PNG】 格式的图片！!');
          return redirect()->back();
        }
      }
    }

    //dd($goods['image']);
    $goods['user_id'] = Auth::user()->id;   // 用户id
    $goods['state'] = $request->goods_state;      // 商品状态：0-未发布 1-发布且正在售卖
    $goods['category_id'] = Category::where('name', $goods['category_id'])->first()->id;  // 分类id

    $goods['tags'] = $request->tag_data;     // 先测试标签1
    $good->fill($goods);
    $good->save();

    // 判断商品发布状态

    if ($goods['goods_state'] == 1) {
      return redirect()->route('home')->with('success', '商品发布成功！');
    } elseif ($goods['goods_state'] == 0) {
      //dd('未发布');
      return redirect()->route('sale_goods', Auth::user()->id);
    }
  }

  // 编辑商品
  public function edit_goods($goods_id, GoodTag $good_tag)
  {

    $good_tag = GoodTag::get();
    $goods_info = Good::where('id', $goods_id)->first();
    // 取标签数据
    $tags = [];
    for ($i = 0; $i < strlen($goods_info->tags); $i++) {
      if ($goods_info->tags[$i] != '-') {
        array_push($tags, $goods_info->tags[$i]);
      } else {
        continue;
      }
    }
    //dd($tags);
    $tags_data = GoodTag::whereIn('id', $tags)->get();

    return view('goods.create_edit_goods', compact('goods_info', 'tags_data', 'good_tag'));
  }

  // 测试-ajax验证商品数据
  // public function create_goods_check(GoodInfoRequest $request){


  //   return [];
  // }




  /* 商品查询 */
  public function goods_search(Request $request, Good $good, Category $category)
  {
    //dd($request->input('category_id', ''));
    $builder = Good::query();
    //dd($request->search);
    if ($category_id = $request->input('category_id', '')) {

      $categories = Category::where('id', $category_id)->first();
      $builder->where('category_id', $category_id);
    }
    if ($key = $request->input('key', '')) {    // 最新发布

      $builder->where('created_at', '>=', Carbon::now()->subWeeks('1')); // 最近一个月
    }
    //dd($request->all());
    // if ($search = $request->input('search', '')) {
    //   dd($search);
    //   if($search != null){
    //     //dd($search);
    //     $like = '%' . $search . '%';
    //     $builder->where(function ($query) use ($like) {
    //       $query->where('title', 'like', $like)
    //             ->orWhere('description', 'like', $like);
    //     });
    //   }
    // }

    $search = $request->search;
    if ($search != null) {
      $like = '%' . $search . '%';
      $builder->where(function ($query) use ($like, $search) {
        $query->where('id', $search)
          ->orWhere('description', 'like', $like)
          ->orWhere('title', 'like', $like);
      });
    }


    if ($state = $request->input('state', '1')) {   // 若没有state，默人 1-已发布正在售卖
      $builder->where('state', $state);
    }

    if ($order = $request->input('order', '')) {
      if ($order == '1') {
        $builder->orderBy('price', 'asc');
      } elseif ($order == '2') {
        $builder->orderBy('price', 'desc');
      } elseif ($order == '3') {
        $builder->orderBy('created_at', 'asc');
      } else {
        $builder->orderBy('created_at', 'desc');
      }
    }

    $goods = $builder->paginate(16);
    if (isset($categories)) {     // 有分类必须再返回分类数据
      return view('pages.root', compact('goods', 'categories', 'search', 'order', 'state'));
    }
    return view('pages.root', compact('goods', 'search', 'order', 'state'));
  }

  /* 商品详情 */
  public function goods_detail($goods_id, Request $request)
  {

    // 非验证用户 跳转
    if (!Auth::user()->activated) {
      return redirect()->route('show_verify');
    }

    $goods_info = Good::where('id', $goods_id)->first();

    // 当商品状态-未发布、审核 时，除了作者，其他人不展示
    //dd($goods_info['user_id']);
    if ($goods_info['user_id'] != Auth::user()->id && $goods_info['state'] == '0' && $goods_info['state'] == '1') {
      return redirect()->back();
    }

    if (!$goods_info) {
      // 定义出错页面
    }


    // 缓存用户浏览过的商品id--浏览量计算
    //Cache::put('name', 'sakura', 180);
    //dd(Cache::get('name'));

    $redis = app("redis.connection"); //相当于 use Illuminate\Support\Facades\Redis;

    // 无序集合-元素不重复
    $res = $redis->sadd('user_' . Auth::user()->id, 'goods_' . $goods_id);   // 插入

    $view_count = $redis->scard('user_' . Auth::user()->id);    // 获取集合的数量

    if ($res) {
      //dd('第一次浏览');
      if ($view_count == 1) {   // 数量为1
        $redis->expire('user_' . Auth::user()->id, 86400);      // 设置过期时间- 1天
      }

      // 浏览量+1
      $old_view_count = $goods_info->view_count + 1;
      $goods_info->update([
        'view_count'  => $old_view_count
      ]);
    } else {
      //dd('已经浏览过');
    }

    $length = substr_count($goods_info->image, ',');
    $images = explode(',', $goods_info->image);
    $user = User::where('id', $goods_info->user_id)->first();

    // 取标签数据
    $tags = [];
    for ($i = 0; $i < strlen($goods_info->tags); $i++) {
      if ($goods_info->tags[$i] != '-') {
        array_push($tags, $goods_info->tags[$i]);
      } else {
        continue;
      }
    }
    //dd($tags);
    $tags_data = GoodTag::whereIn('id', $tags)->get();
    //dd($tags_data);

    $comments = Comment::where('goods_id', $goods_id)->orderBy('created_at', 'desc')->get();
    //$c_count=$comments->count();  // 商品评论
    //dd($comments);

    return view('goods.detail', compact('comments', 'tags_data'), compact('images', 'length', 'goods_info', 'user'));
  }
}
