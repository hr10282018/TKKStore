<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Handlers\ImageUploadHandler;    // 上传图片处理器
use App\Http\Requests\UserInfoRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Good;
use App\Models\UserVisible;
use Mail;
use Illuminate\Support\Str;
use Auth;

class UsersController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      'except' => ['name_ajax','email_ajax','show', 'create', 'register']   //
    ]);

    $this->middleware('guest', [
      'only' => ['create']
    ]);

    //限制访问频率1分钟3次
    $this->middleware('throttle:3,1')->only('edit_check','ajax_visible_data');
    
  }


  /* 注册处理 */

  public function create()    // 注册界面
  {
    return view('users.signup');
  }
  public function register(Request $request)  // 注册信息验证
  {
    $this->validate($request, [
        'name' => 'required|unique:users|max:50',
        'email' => 'required|regex:/.{6,}@qq.com/|unique:users|max:255',
        'password' => 'required|confirmed|min:6',
        'captcha' => ['required', 'captcha'],
      ],
      [
      //返回的信息
      'captcha.required' => '验证码不能为空',
      'captcha.captcha' => '请输入正确的验证码',
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => password_hash($request->password, PASSWORD_DEFAULT),
      ]);

    session()->flash('success', '注册成功~');

    return redirect('/login');
    //return redirect()->route('users.show', [$user]);
  }

  public function name_ajax($name){     // ajax验证用户名
    //return $name;
    $user_name = User::where('name', $name)->first();
    if($user_name){
      return  'false';
    }else{
      return 'true';
    }
  }
  public function email_ajax($email,Request $request){ // ajax验证邮箱
    $user = User::where('email', $email)->first();
    if($user){
      return 'false';
    }else{
      return 'true';
    }
  }
  /* end */

  /* 邮箱处理 */

  // protected function sendEmailConfirmationTo($user)   // 自定义发送邮箱
  // {
  //   $view = 'users.email.confirm';
  //   $data = compact('user');
  //   $from = 'summer@example.com';
  //   $name = 'Summer';
  //   $to = $user->email;
  //   $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

  //   Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
  //     $message->from($from, $name)->to($to)->subject($subject);
  //   });
  // }
  // public function confirmEmail($token)    // 验证邮箱
  // {
  //   $user = User::where('activation_token', $token)->firstOrFail();

  //   $user->activated = true;
  //   $user->activation_token = null;
  //   $user->save();
  //   Auth::login($user);
  //   session()->flash('success', '恭喜你，激活成功！');
  //   return redirect()->route('home', [$user]);
  // }



  /* 用户主页展示-begin */

  public function user_show(User $user, UserVisible $user_visible){

    $user_visible = UserVisible::where('user_id', $user->id)->first();    // 该用户可见设置
    return view('users.detail._home_info',compact('user','user_visible')); // 默认路由-用户基本信息展示

  }
  public function sale_goods(User $user,Category $category){    // 我的商品展示

    //dd($user);
    $goods=Good::where('user_id',$user->id)->paginate(3);

    $image=array();
    //$image=$goods->first()->image;
    for($i=0; $i<sizeof($goods); $i++){
      $image[]=explode(',',$goods[$i]->image)[0];
    }

    return view('users.detail._sale_goods',compact('user','goods','image'));
  }

  /* end */


  /* 用户所有信息编辑 */

  // 个人信息编辑
  public function edit(User $user){      // 默认路由-用户基本信息编辑
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_info',compact('user'));
  }
  // 个人信息编辑-处理表单
  public function edit_check(User $user,UserInfoRequest $request){
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
    if(json_decode($request->email_cg)=='true'){   // 用户修改了邮箱，则需要重新登录验证邮箱
      // 还需要把邮箱激活状态改为false
      $user->activated = false;
      $user->activation_token = Str::random(10);
      $user->email_verified_at = null;
      $user->save();

      session()->flush(); // 退出登录
      return 'login';
    }
    return [];
  }

  // 用户头像编辑
  public function edit_avatar(User $user){
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_avatar',compact('user'));
  }
  // 用户头像编辑-处理表单
  public function avatar_check(Request $request,User $user,ImageUploadHandler $uploader){
    //dd($request->avatar);  // 测试上传头像
    // $this->validate($request, [
    //   'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
    // ],[
    //   'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
    //   'avatar.dimensions' => '图片的清晰度不够，宽和高需要 208px 以上',
    // ]);
    $this->authorize('update_user_info', $user);  // 授权判断
    $data=$request->all();
    $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);//416-裁剪图像后的尺寸
    if ($result) {
      $data['avatar'] = $result['path'];
      $user->update($data);
      session()->flash('success', '头像修改成功！');
      return redirect()->route('user_edit_avatar', $user->id);
    }else{
      session()->flash('warning', '修改失败！请上传png,gif,jpg,jpeg格式的图片');
      return redirect()->route('user_edit_avatar', $user->id);
    }
  }

  // 用户重设密码
  public function edit_password(User $user){
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_password',compact('user'));
  }
  // 用户重设密码-处理表单
  public function password_check(Request $request,User $user){
    //dd($request->password);
    $this->authorize('update_user_info', $user);  // 授权判断
    $this->validate($request, [
      'password' => 'required|confirmed|min:6'
    ]);
    $data=[];
    $data['password'] = bcrypt($request->password);
    $user->update($data);

    session()->flash('success', '密码修改成功！');
    return redirect()->route('user_edit_password', $user->id);
  }

  // 用户显示设置
  public function edit_visible(User $user){
    //dd($user->name);
    $this->authorize('update_user_info', $user);  // 授权判断

    $user_visible = UserVisible::where('user_id', Auth::user()->id)->first();
    $checked='';
    // 开关样式-选中
    if(($user_visible->v_email || $user_visible->v_phone || $user_visible->v_university|| $user_visible->v_faculty || $user_visible->v_number || $user_visible->v_r_name)){
      $checked='checked';
    }
    return view('users.edit._edit_visible',compact('user','user_visible'),['user_vis'=>$checked]);
  }
  // ajax获取用户可见设置
  public function ajax_visible(){

    $user_visible = UserVisible::where('user_id', Auth::user()->id)->first();
    $res=[];
    array_push($res,$user_visible);
    return  $res[0];
  }
  // ajax修改用户可见设置
  public function ajax_visible_data(UserVisible $user_visible,Request $request){

    $user_visible->update($request->only([
      'v_email',
      'v_phone',
      'v_university',
      'v_faculty',
      'v_number',
      'v_r_name',
    ]));
    return [];
  }


  /* end */

  /* 出售商品处理 */
  public function delete_goods(Request $request){   // 删除出售商品
    // dd($request->all()['goods_id']); //商品id

    Good::where('id', $request->all()['goods_id'])->first()->delete();  // 分类id

    session()->flash('success', '成功删除该商品！');
    return back();
  }


  /* 预订相关 */
  public function booking_notice($user){   // 显示预订通知


    $bookings=Booking::where('user_id',$user)->where('user_state',null)->paginate(3);
    $user=User::where('id',$user)->first();
    //$buyer=User::where('id',$user)->first();

    return view('users.detail._booking_notice',compact('user'),compact('bookings'));

  }
  public function agree_booking($user,$booking_id){    // 处理接受预订
    //dd($user);
    //dd($booking_id);
    Booking::where('id',$booking_id)->update(['user_state'=>'1']);

    return back()->with('success','成功接受预订！');
  }
  public function refuse_booking($user,$booking_id){    // 处理拒绝预订
    //dd($user);
    //dd($booking_id);
    Booking::where('id',$booking_id)->update(['user_state'=>'0']);

    return back()->with('success','成功拒绝预订！');
  }

  public function user_booking($user){   // 显示我的预订

    $bookings=Booking::where('buyer_id',$user);
    $no_reply_booking=$bookings->where('user_state',null)->paginate(3);

    $yes_reply_booking=Booking::where('buyer_id',$user)->whereNotNull('user_state')->paginate(3);

    $user=User::where('id',$user)->first();
    //$buyer=User::where('id',$user)->first();

    return view('users.detail._user_notice',compact('user'),compact('no_reply_booking','yes_reply_booking'));
  }

}
