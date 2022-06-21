<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Order;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use App\Models\GoodTag;


class GoodsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤
      
      'except' => ['goods_search']
    ]);
  }

  /* 发布商品 */
  public function create_goods(GoodTag $good_tag)
  {
    $good_tag = GoodTag::get();
    //dd($good_tag);

    // 预定未处理
    $booking=Booking::where('user_id',Auth::user()->id)->where('user_state',Booking::seller_processing_booking)->exists();

    // 订单未处理
    $order=Order::where('user_id',Auth::user()->id)->where('seller_state',Order::seller_pending_order)->orWhere(function($query){
      $query->where('buyer_id',Auth::user()->id)->where('buyer_state',Order::buyer_pending_order)->where('seller_state',Order::seller_confirm_order);
    })->exists();
    

    if($booking || $order){
      session()->flash('danger', '你还有未处理的预定通知或出售订单，无法发布商品！');
      return redirect()->back();
    }

    return view('goods.create_edit_goods', compact('good_tag','booking','order'));
  }

  // 处理发布商品数据
  public function create_goods_check(Request $request, Good $good, ImageUploadHandler $uploader)
  {
  
    $credentials = $this->validate($request, [    
      'title' => ['required',  'max:255'],
      'description' => ['required',  'max:512'],
      ], [
     
    ]);

    $goods = $request->all();

    //dd($goods);

    if ($goods['goods_old_img'] == null  && !isset($goods['goods_img'])) {
      // dd('你的图片未上传');
      session()->flash('null_data', '你还有未填的选项，无法提交！');
      return redirect()->back();
    }

    if (in_array(null, $goods) && $goods['goods_old_img'] != null) {
      //dd('你还有未填的选项');
      session()->flash('null_data', '你还有未填的选项，无法提交！');
      return redirect()->back();
    }


    $goods['image'] = '';

    if ($goods['goods_old_img']) {    // 编辑
      //dd('编辑');
      //dd($goods['goods_old_img']);

      $goods['goods_old_img'] = explode(',', $goods['goods_old_img']);

      //dd($goods['goods_old_img']);

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

    
    $image_toArray=explode(',',$goods['image']);
    array_pop($image_toArray);
    $goods['image']=$image_toArray;

    //dd($goods['image']);

    $goods['user_id'] = Auth::user()->id;   // 用户id
    $goods['state'] = $request->goods_state;      // 商品状态：0-未发布 1-发布且正在售卖
    $goods['category_id'] = Category::where('name', $goods['category_id'])->first()->id;  // 分类id

    $goods['tags'] = $request->tag_data;     // 先测试标签1

    //dd($goods);
    if ($goods['goods_old_img']) {
      $good=Good::where('id',$goods['id']);
      $good->update([
        'title' => $goods['title'],
        'description' => $goods['description'],
        'image' => $goods['image'],
        'state' => $goods['state'],
        'price' => $goods['price'],
        'old_price' => $goods['old_price'],
        'category_id' => $goods['category_id'],
        'tags' => $goods['tags'],
      ]);
    }else{
      $good->fill($goods);
      $good->save();
    }
    

    // 判断商品发布状态

    if ($goods['goods_state'] == Good::goods_state_in_check) {     // 审核
      
      return redirect()->route('sale_goods',[Auth::user()->id,Good::goods_state_in_check])->with('success', '商品发布成功，等待审核！');
    } elseif ($goods['goods_state'] == Good::goods_state_in_release) {
      //dd('未发布');
      
      return redirect()->route('sale_goods', Auth::user()->id)->with('success', '商品保存成功！');
    }
  }

  // 编辑商品
  public function edit_goods($goods_id, GoodTag $good_tag)
  {

    //dd($goods_id);
    $good_tag = GoodTag::get();       // 所有 tag
    $goods_info = Good::where('id', $goods_id)->first();

    $this->authorize('eidt_goods', $goods_info);  // 授权 -- 当商品-未发布、审核 时，非作者其不展示

    
    // 预定未处理
    $booking=Booking::where('user_id',Auth::user()->id)->where('user_state',Booking::seller_processing_booking)->exists();

    // 订单未处理
    $order=Order::where('user_id',Auth::user()->id)->where('seller_state',Order::seller_pending_order)->orWhere(function($query){
      $query->where('buyer_id',Auth::user()->id)->where('buyer_state',Order::buyer_pending_order)->where('seller_state',Order::seller_confirm_order);
    })->exists();

    if($booking || $order){
      session()->flash('danger', '你还有未处理的预定通知或出售订单，无法编辑商品！');
      return redirect()->back();
    }

   


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
    $tags_data = GoodTag::whereIn('id', $tags)->get();      // 该商品的tag


    //dd($goods_info);
    $goods_info->image=implode(',',$goods_info->image);
    
    //dd($goods_info->image);

    return view('goods.create_edit_goods', compact('goods_info', 'tags_data', 'good_tag'));
  }



  /* 商品查询 */
  public function goods_search(Request $request, Good $good, Category $category)
  {
    //dd($request->input('key', ''));
    $builder = Good::query();
    //dd($request->search);
    if ($category_id = $request->input('category_id', '')) {

      $categories = Category::where('id', $category_id)->first();
      $builder->where('category_id', $category_id);
    }

    $search = $request->search;
    if ($search != null) {
      $like = '%' . $search . '%';
      $builder->where(function ($query) use ($like, $search) {
        $query->where('id', $search)
          ->orWhere('description', 'like', $like)
          ->orWhere('title', 'like', $like);
      });
    }

    if ($state = $request->input('state', Good::goods_state_in_selling)) {   // 若没有state，默认商品状态-正出售
      //dd($state);
      $builder->where('state', $state);
    }
    
    if ($key = $request->input('key', '') ) {    // 最新发布
      if($key == 'new'){
        //dd('new');
        //dd($request->time);
        if($time = $request->input('time', '3')){
          $builder->where('created_at', '>=', Carbon::now()->subDays($time)); // 用户选择
        }
      }
    }
    if ($order = $request->input('order', '1')) {
      //dd($order);
      if ($order == '1') {
        $builder->orderBy('created_at', 'desc');
        
      } elseif ($order == '2') {
        $builder->orderBy('created_at', 'asc');
        
      } elseif ($order == '3') {
        $builder->orderBy('price', 'asc');
        
      }elseif ($order == '4') {
        $builder->orderBy('price', 'desc');
      }
    }

    $goods = $builder->paginate(16);

    if (isset($categories)) {     // 有分类必须再返回分类数据
      return view('pages.root', compact('goods', 'categories', 'search', 'order', 'state'));
    }
    return view('pages.root', compact('goods', 'search', 'order', 'state'));
  }

  // 热门商品
  public function goods_hot(Good $goods){
    
    //dd('hot');
    $hot_goods = $goods->getHotGoods();
    //dd($hot_goods);

    return view('pages.root', compact('hot_goods'));
  }

  /* 商品详情 */
  public function goods_detail($goods_id, Request $request)
  {

    // 非验证用户 跳转
    // if (!Auth::user()->activated) {
    //   return redirect()->route('show_verify');
    // }

    $goods_info = Good::where('id', $goods_id)->with('bookings','orders')->first();    // 关联

    $this->authorize('seller_goods_detail', $goods_info);  // 授权 -- 当商品-未发布、审核 时，非作者其不展示

    //dd($goods_info->image);

    // 获取 预定数据（预定中）
    $booking_data=$goods_info->bookings->whereIn('user_state',[Booking::seller_agree_booking,Booking::seller_processing_booking])->first(); 

    $orders_data=$goods_info->orders->first();
    

    // if (!$goods_info) {      // 定义出错页面

    //   //throw new \Exception('没有此商品');
    // }

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
        $redis->expire('user_' . Auth::user()->id, Good::user_view_goods);      // 设置过期时间
      }

      // 浏览量+1
      $old_view_count = $goods_info->view_count + 1;
      $goods_info->update([
        'view_count'  => $old_view_count
      ]);
    } else {
      //dd('已经浏览过');
    }


    //dd($goods_info->image);
    //$length = substr_count($goods_info->image, ',');

    $length = count($goods_info->image);
    // dd($length);
    //dd($goods_info->ImageToArray()[0]);


    //$images = explode(',', $goods_info->image);
    $images=$goods_info->image;

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

    $comments = Comment::where('goods_id', $goods_id)->orderBy('created_at', 'desc')->paginate(5);
    //$c_count=$comments->count();  // 商品评论

    //dd($comments);

    //$booking=Booking::where('user_state','2')->where('goods_id',$goods_id)->where('buyer_id',$goods_id)->first();

    return view('goods.detail', compact('comments', 'tags_data','booking_data','orders_data'), compact('images', 'length', 'goods_info', 'user'));
  }

}
