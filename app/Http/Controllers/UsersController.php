<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;    // 上传图片处理器
use App\Http\Requests\UserInfoRequest;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Good;
use App\Models\Order;
use App\Models\UserVisible;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UsersController extends Controller
{
  use AuthenticatesUsers;

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      'except' => ['name_ajax', 'email_ajax', 'show', 'create', 'register']   //
    ]);

    $this->middleware('guest', [
      'only' => ['create']
    ]);

    // 限制访问频率1分钟3次
    // 修改个人资料 修改可见设置 注册 头像 密码
    $this->middleware('throttle:3,1')->only('edit_check', 'register', 'avatar_check', 'password_check', 'ajax_visible_data');
    //$this->middleware('throttle:3,1')->only('ajax_visible_data');

  }



  /* 注册处理 */

  public function create()    // 注册界面
  {
    return view('users.signup');
  }
  public function register(Request $request)  // 注册信息验证
  {
    //dd($request->All());
    $this->validate(
      $request,
      [
        'name' => 'required|unique:users|between:3,25',
        'email' => 'required|regex:/.{8,}@qq.com/|unique:users|max:32',
        'password' => 'required|confirmed|min:6|max:32',
        'captcha' => ['required', 'captcha'],
      ],
      [
        //返回的信息
        'captcha.required' => '验证码不能为空',
        'captcha.captcha' => '请输入正确的验证码',
        'name.unique'  =>  '该名称已被注册，请重新填写！!',
        'email.unique'  => '该邮箱已被注册，请重新填写！!',
        'password.confirmed' => '两次密码不一致，请重新填写！!',
      ]
    );

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => password_hash($request->password, PASSWORD_DEFAULT),  // Hash make加密 check验证
    ]);

    // dd($user);
    // 创建 对应可见表
    UserVisible::create([
      'user_id' => $user->id
    ]);


    session()->flash('success', '注册成功~');

    return redirect('/login');
    //return redirect()->route('users.show', [$user]);
  }

  public function name_ajax($name)
  {     // ajax验证用户名
    //return $name;
    $user_name = User::where('name', $name)->first();
    if ($user_name) {
      return  'false';
    } else {
      return 'true';
    }
  }
  public function email_ajax($email, Request $request)
  { // ajax验证邮箱
    $user = User::where('email', $email)->first();
    if ($user) {
      return 'false';
    } else {
      return 'true';
    }
  }
  /* end */

  /* 邮箱处理 */


  /* 用户主页展示-begin */

  public function user_show(User $user, UserVisible $user_visible)
  {

    $user_visible = UserVisible::where('user_id', $user->id)->first();    // 该用户可见设置
    return view('users.detail._home_info', compact('user', 'user_visible')); // 默认路由-用户基本信息展示

  }

  public function user_comment(User $user)    // 我的评论
  {

    $comments = Comment::where('user_id', $user->id)->orderBy('created_at', 'desc');
    $count = $comments->count();
    $comments = $comments->with('goods')->paginate(5);

    // 可见数据
    $user_visible = $user->userVisibles;

    return view('users.detail._user_comments', compact('user', 'comments', 'count', 'user_visible'));
  }

  public function buy_goods(User $user, Request $request)   // 订购商品-预定|已购
  {

    //$goods=Good::where('user_id',$user->id)->where('state',$state);
    $booking_goods_count = 0;
    $booking_goods = [];

    $buy_goods_count = 0;
    $buy_goods = [];

    $booking_goods = Booking::query()->select(DB::raw('goods_id ,count(*) as booking_count,max(created_at) as created_at')) // 预定商品 id和次数, 按最晚时间取出
      ->where('booker_id', $user->id)->with('goods')
      ->groupBy('goods_id');


    $booking_goods_count = $booking_goods->get()->count();
    $booking_goods = $booking_goods->paginate(5);

    $buy_goods = $user->buyerOrders[0] ?? $user->buyerOrders;
    if(count($buy_goods)==0){
      $buy_goods_count=0;

    }else{
      $buy_goods_count = $buy_goods->goods->where('state', Good::goods_state_in_sold)->get()->count();
      $buy_goods = $buy_goods->paginate(5);
    }

    // 取可见数据
    $user_visible = UserVisible::where('user_id', $user->id)->first();

    return view('users.detail._booking_buy_goods', compact('user', 'user_visible', 'booking_goods', 'booking_goods_count', 'buy_goods', 'buy_goods_count'));
  }


  // 发布商品
  public function sale_goods(User $user, $state = Good::goods_state_in_release)    // 默认商品状态-预发布
  {

    //dd($state);

    $goods = Good::where('user_id', $user->id)->where('state', $state)->orderBy('created_at', 'desc');
    $count = $goods->count();

    //$count=sizeof($goods->get());
    $goods = $goods->paginate(5);

    $image = array();
    //$image=$goods->first()->image;
    //dd($image);

    for ($i = 0; $i < sizeof($goods); $i++) {
      $image[] = $goods[$i]->image[0];
    }


    //dd($image);

    // 取可见数据
    $user_visible = $user->userVisibles;
    return view('users.detail._sale_goods', compact('user', 'goods', 'image', 'count', 'user_visible', 'state'));
  }
  public function search_sale_goods(User $user, $state = Good::goods_state_in_release, Request $request)
  {

    $search = '%' . $request->content . '%';

    $goods = Good::where('user_id', $user->id)->where('state', $state)->where(function ($query) use ($search) {
      $query->where('title', 'like', $search)->orWhere('description', 'like', $search);
    })->orderBy('created_at', 'desc');

    $count = $goods->count();

    //$count=sizeof($goods->get());
    $goods = $goods->paginate(5);

    $image = array();
    //$image=$goods->first()->image;
    //dd($image);

    for ($i = 0; $i < sizeof($goods); $i++) {
      $image[] = $goods[$i]->image[0];
    }


    //dd($image);

    // 取可见数据
    $user_visible = $user->userVisibles;
    //dd($state);
    return view('users.detail._sale_goods', compact('user', 'goods', 'image', 'count', 'user_visible', 'state'));
  }



  /* end */


  /* 用户所有信息编辑 */

  // 个人信息编辑
  public function edit(User $user)
  {      // 默认路由-用户基本信息编辑
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_info', compact('user'));
  }
  // 个人信息编辑-处理表单
  public function edit_check(User $user, UserInfoRequest $request)
  {
    //return ($request->All());
    $user->update($request->only([
      'name',
      'email',
      'sex',
      'signature',
      'phone',
      'university',
      'faculty',
      'number',
      'r_name',
    ]));
    //return json_encode($request->email_cg);
    if (json_decode($request->email_cg) == 'true') {   // 用户修改了邮箱，则需要重新登录验证邮箱
      // 还需要把邮箱激活状态改为false
      $user->activated = false;
      $user->activation_token = Str::random(10);
      $user->email_verified_at = null;
      $user->save();

      session()->flush(); // 退出登录
      //Auth::logout();

      return 'login';
    }
    return [];
  }

  // 用户头像编辑
  public function edit_avatar(User $user)
  {
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_avatar', compact('user'));
  }
  // 用户头像编辑-处理表单
  public function avatar_check(Request $request, User $user, ImageUploadHandler $uploader)
  {
    //dd($request->avatar);  // 测试上传头像

    if (!isset($request->avatar)) {
      //dd('null');
      session()->flash('null_data', '请上传图片！！');
      return redirect()->back();
    }
    $this->authorize('update_user_info', $user);  // 授权判断

    $data = $request->all();
    $result = $uploader->save($request->avatar, 'avatars', $user->id); // -裁剪图像后的尺寸
    if ($result) {
      $data['avatar'] = $result['path'];
      $user->update($data);
      session()->flash('success', '头像修改成功！!');
      return redirect()->route('user_edit_avatar', $user->id);
    } else {
      session()->flash('wrong_type', '请选择 【GIF JPG JPEG PNG】 格式的图片！!');
      return redirect()->route('user_edit_avatar', $user->id);
    }
  }

  // 用户重设密码
  public function edit_password(User $user)
  {
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_password', compact('user'));
  }
  // 用户重设密码-处理表单
  public function password_check(Request $request, User $user)
  {
    //dd($request->password);
    $this->authorize('update_user_info', $user);  // 授权判断
    $this->validate($request, [
      'password' => 'required|confirmed|between:6,32'
    ]);
    $data = [];
    $data['password'] = bcrypt($request->password);
    $user->update($data);

    session()->flash('success', '密码修改成功！');
    return redirect()->route('user_edit_password', $user->id);
  }

  // 用户显示设置
  public function edit_visible(User $user)
  {
    //dd($user->name);
    $this->authorize('update_user_info', $user);  // 授权判断

    $user_visible = UserVisible::where('user_id', Auth::user()->id)->first();

    $checked = '';    // 记录 个人信息 是否选中
    $checked_buy_goods = '';  // 记录 购买商品 是否选中
    $checked_create_goods = '';  // 记录 发布商品 是否选中
    $checked_comment = '';  // 记录 个人评论 是否选中

    // 设置开关样式-选中  
    if (($user_visible->v_email || $user_visible->v_phone || $user_visible->v_university || $user_visible->v_faculty || $user_visible->v_number || $user_visible->v_r_name)) {
      $checked = 'checked';
    }
    if ($user_visible->v_buy_booking_goods || $user_visible->v_buy_sale_goods) {    // 订购商品
      $checked_buy_goods = 'checked';
    }
    if ($user_visible->v_booking_goods || $user_visible->v_sale_goods || $user_visible->v_saled_goods) {    // 发布商品
      $checked_create_goods = 'checked';
    }
    if ($user_visible->v_comment) {
      $checked_comment = 'checked';
    }

    return view('users.edit._edit_visible', compact('user', 'user_visible'), ['user_vis' => $checked, 'buy_goods_vis' => $checked_buy_goods, 'create_goods_vis' => $checked_create_goods, 'comment_vis' => $checked_comment]);
  }
  // ajax获取用户可见设置
  public function ajax_visible()
  {

    $user_visible = UserVisible::where('user_id', Auth::user()->id)->first();
    $res = [];
    array_push($res, $user_visible);
    return  $res[0];
  }
  // ajax修改用户可见设置
  public function ajax_visible_data(UserVisible $user_visible, Request $request)
  {

    $user_visible->update($request->only([
      'v_email',
      'v_phone',
      'v_university',
      'v_faculty',
      'v_number',
      'v_r_name',
      'v_buy_booking_goods',
      'v_buy_sale_goods',
      'v_booking_goods',
      'v_sale_goods',
      'v_saled_goods',
      'v_comment',
    ]));
    return [];
  }


  /* end */

  /* 出售商品处理 */
  public function del_goods_ajax(Good $goods)
  {   // 删除 发布商品
    //dd($request->all()); //商品id

    Good::where('id', $goods->id)->delete();  // 

    return [];
  }


  /* 预订相关 */

  public function booking_notice(User $user, Request $request)      // 预订通知
  {

    //dd($user->BookingNotifyRoute($user));

    $bookings = Booking::where('user_id', $user->id);        // 2-未处理

    $no_reply_booking = [];
    $yes_reply_booking = [];
    $no_reply_count = 0;
    $yes_reply_count = 0;

    if ($request->reply == 'no') {
      $no_reply_booking = $bookings->where('user_state', Booking::seller_processing_booking)->orderBy('created_at', 'desc');     // 卖家状态-待回复
      $no_reply_count = $no_reply_booking->count();    // 总数

      $no_reply_booking = $no_reply_booking->with('user', 'goods')->paginate(5);
    }
    if ($request->reply == 'yes') {
      $yes_reply_booking = $bookings->where('user_state', '!=', Booking::seller_processing_booking)->orderBy('updated_at', 'desc');    // 已回复
      $yes_reply_count = $yes_reply_booking->count();    // 总数

      //$yes_reply_count=count($yes_reply_booking->get());
      //dd( count($yes_reply_booking->get()));
      $yes_reply_booking = $yes_reply_booking->with('buyer', 'goods')->paginate(5);
    }
    // dd($no_reply_booking);

    return view('users.detail._booking_notice', compact('user'), compact('no_reply_booking', 'yes_reply_booking', 'no_reply_count', 'yes_reply_count'));
  }


  public function user_booking(User $user, Request $request)    // 我的预订
  {

    //dd($request->all());
    $bookings = Booking::where('booker_id', $user->id);

    $no_reply_booking = [];
    $yes_reply_booking = [];
    $no_reply_count = 0;
    $yes_reply_count = 0;


    if ($request->reply == 'no') {
      $no_reply_booking = $bookings->where('user_state', Booking::seller_processing_booking)->orderBy('created_at', 'desc');     // 2-待回复
      $no_reply_count = $no_reply_booking->count();    // 待回复总数
      $no_reply_booking = $no_reply_booking->with('user', 'goods')->paginate(5);
    }
    if ($request->reply == 'yes') {
      $yes_reply_booking = $bookings->where('user_state', '!=', Booking::seller_processing_booking)->orderBy('updated_at', 'desc');    // 已回复
      $yes_reply_count = $yes_reply_booking->count();    // 已回复总数

      $yes_reply_booking = $yes_reply_booking->with('user', 'goods')->paginate(5);
    }


    return view('users.detail._user_notice', compact('user'), compact('no_reply_booking', 'yes_reply_booking', 'no_reply_count', 'yes_reply_count'));
  }
  // public function search_booking(User $user, Request $request){     // 搜索 我的预定
  //   $bookings = Booking::where('booker_id', $user->id);

  //   $no_reply_booking = [];
  //   $yes_reply_booking = [];
  //   $no_reply_count = 0;
  //   $yes_reply_count = 0;

  //   $search='%' . $request->content . '%';
  //   if ($request->reply == 'no') {

  //     $no_reply_booking = $bookings->where('user_state', Booking::seller_processing_booking)->where()->orderBy('created_at', 'desc');     // 2-待回复
  //     $no_reply_count = $no_reply_booking->count();    // 待回复总数
  //     $no_reply_booking = $no_reply_booking->with('user', 'goods')->paginate(5);
  //   }
  //   if ($request->reply == 'yes') {
  //     $yes_reply_booking = $bookings->where('user_state', '!=', Booking::seller_processing_booking)->orderBy('updated_at', 'desc');    // 已回复
  //     $yes_reply_count = $yes_reply_booking->count();    // 已回复总数

  //     $yes_reply_booking = $yes_reply_booking->with('user', 'goods')->paginate(5);
  //   }


  // }


  public function buyer_order(User $user, Request $request)  // 我的订单
  {

    $orders = Order::where('buyer_id', $user->id)->where('is_delete', Order::not_deleted);

    $pending_orders_count = 0;
    $processed_orders_count = 0;

    $pending_orders = [];
    $processed_orders = [];

    $type = $request->type;

    if ($type == 'pending') {
      $pending_orders = $orders->where('buyer_state', Order::buyer_pending_order)->orderBy('updated_at', 'desc');   // 买家未处理 (只有1-3 ，不包括 2-3)
      $pending_orders_count = $pending_orders->count();
      $pending_orders = $pending_orders->with('user', 'buyer', 'goods')->paginate(5);
    } elseif ($type == 'processed') {
      $processed_orders = $orders->where('buyer_state', '!=', Order::buyer_pending_order)->orderBy('updated_at', 'desc');  // 买家状态-已处理(0-1-2-4),则考虑未生效和已生效订单
      $processed_orders_count = $processed_orders->count();
      $processed_orders = $processed_orders->with('user', 'buyer', 'goods')->paginate(5);
    }

    //dd($pending_orders);

    return view('users.detail._buy_order', compact('user'), compact('pending_orders', 'pending_orders_count', 'processed_orders', 'processed_orders_count', 'type'));
  }

  public function search_buyer_order(User $user, Request $request)
  {     // 搜索-我的订单

    $orders = Order::where('buyer_id', $user->id)->where('is_delete', Order::not_deleted);

    $search = '%' . $request->content . '%';

    $pending_orders_count = 0;
    $processed_orders_count = 0;

    $pending_orders = [];
    $processed_orders = [];
    $type = $request->type;

    if ($type == 'pending') {
      $pending_orders = $orders->where('buyer_state', Order::buyer_pending_order)->where('no', 'like', $search)->orderBy('updated_at', 'desc');   // 买家未处理 (只有1-3 ，不包括 2-3)
      $pending_orders_count = $pending_orders->count();
      $pending_orders = $pending_orders->with('user', 'buyer', 'goods')->paginate(5);
    } elseif ($type == 'processed') {
      $processed_orders = $orders->where('buyer_state', '!=', Order::buyer_pending_order)->where('no', 'like', $search)->orderBy('updated_at', 'desc');  // 买家状态-已处理(0-1-2-4),则考虑未生效和已生效订单
      $processed_orders_count = $processed_orders->count();
      $processed_orders = $processed_orders->with('user', 'buyer', 'goods')->paginate(5);
    }

    //dd($pending_orders);

    return view('users.detail._buy_order', compact('user'), compact('pending_orders', 'pending_orders_count', 'processed_orders', 'processed_orders_count', 'type'));
  }



  public function seller_order(User $user, Request $request)   // 出售订单
  {
    // $redis = app("redis.connection");
    $orders = Order::where('user_id', $user->id)->where('is_delete', Order::not_deleted);

    $pending_orders_count = 0;
    $processed_orders_count = 0;

    $pending_orders = [];
    $processed_orders = [];

    $type = $request->type;
    if ($type == 'pending') {
      $pending_orders = $orders->where('seller_state', Order::seller_pending_order)->orderBy('updated_at', 'desc');   // 卖家状态-待处理(2)，则订单都是未生效
      $pending_orders_count = $pending_orders->count();
      $pending_orders = $pending_orders->with('user', 'buyer', 'goods')->paginate(5);
    } elseif ($type == 'processed') {
      $processed_orders = $orders->where('seller_state', '!=', Order::seller_pending_order)->orderBy('updated_at', 'desc');  // 卖家状态-已处理(0-1),则考虑未生效和已生效订单
      $processed_orders_count = $processed_orders->count();
      $processed_orders = $processed_orders->with('user', 'buyer', 'goods')->paginate(5);
    }


    return view('users.detail._seller_order', compact('user'), compact('pending_orders_count', 'pending_orders', 'processed_orders', 'processed_orders_count', 'type'));
  }

  public function search_seller_order(User $user, Request $request)
  {

    $orders = Order::where('user_id', $user->id)->where('is_delete', Order::not_deleted);

    $pending_orders_count = 0;
    $processed_orders_count = 0;

    $pending_orders = [];
    $processed_orders = [];
    $type = $request->type;
    $search = '%' . $request->content . '%';

    if ($type == 'pending') {
      $pending_orders = $orders->where('seller_state', Order::seller_pending_order)->where('no', 'like', $search)->orderBy('updated_at', 'desc');   // 卖家状态-待处理(2)，则订单都是未生效
      $pending_orders_count = $pending_orders->count();
      $pending_orders = $pending_orders->with('user', 'buyer', 'goods')->paginate(5);
    } elseif ($type == 'processed') {
      $processed_orders = $orders->where('seller_state', '!=', Order::seller_pending_order)->where('no', 'like', $search)->orderBy('updated_at', 'desc');  // 卖家状态-已处理(0-1),则考虑未生效和已生效订单
      $processed_orders_count = $processed_orders->count();
      $processed_orders = $processed_orders->with('user', 'buyer', 'goods')->paginate(5);
    }


    return view('users.detail._seller_order', compact('user'), compact('pending_orders_count', 'pending_orders', 'processed_orders', 'processed_orders_count', 'type'));
  }
}
