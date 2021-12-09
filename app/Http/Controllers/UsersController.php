<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Handlers\ImageUploadHandler;    // 上传图片处理器
use Mail;

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
    $user = User::where('name', $name)->first();
    if($user){
      return false;
    }else{
      return true;
    }
  }
  public function email_ajax($email){ // ajax验证邮箱
    $user = User::where('email', $email)->first();
    if($user){
      return false;
    }else{
      return true;
    }
  }

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



  /* 用户主页展示 */

  public function user_show(User $user){

    return view('users.detail._home_info',compact('user')); // 默认路由-用户基本信息展示
  }



   /* 用户资料编辑 */

  public function edit(User $user){       // 默认路由-用户基本信息编辑

    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_info',compact('user'));
  }


  public function edit_avatar(User $user){    // 用户头像编辑
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_avatar',compact('user'));
  }
  public function avatar_check(Request $request,User $user,ImageUploadHandler $uploader){   // 处理用户头像编辑
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

  public function edit_password(User $user){    // 用户重设密码编辑
    $this->authorize('update_user_info', $user);  // 授权判断
    return view('users.edit._edit_password',compact('user'));
  }
  public function password_check(Request $request,User $user){       // 用户重设面表单
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


}
