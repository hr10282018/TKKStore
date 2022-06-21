<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Str;

use Illuminate\Support\Facades\Hash;

class SessionsController extends Controller
{

  //use AuthenticatesUsers;
  public function __construct()
  {
    $this->middleware('guest', [
      'only' => ['login']
    ]);

    //限制访问频率1分钟3次
    // 激活账号再次发送邮件 登录  重设密码发送邮件
    $this->middleware('throttle:3,1')->only('second_send_email','login_check','verify_password_send_email');  
  }


  /* 登录处理 */

  public function login()     // 登录界面
  {   
    return view('users.login');
  }
  public function login_check(Request $request, User $user)   // 登录信息
  {  
    $credentials = $this->validate($request, [
      'email' => ['required', 'regex:/^[a-zA-Z\d]{8,}@qq.com$/', 'max:32','exists:users,email'],
      'password' => 'required',
    ], [
      'email.regex' => '请填写你的QQ邮箱！',
      'email.exists' => '邮箱或密码错误！'
    ]);


    $user=User::where('email',$request->email)->first();

    if(!Hash::check($request->password,$user->password)){   // 验证密码

      session()->flash('email_no_pwd', '邮箱或密码错误！');
      return redirect()->back()->withInput();
    }
    
   
    if ($user->activated) {
      if (Auth::attempt($credentials, $request->has('remember'))) {  // 第二个参数bool(记住我)

        //dd($request->session());
        // $rememberTokenName = Auth::getRecallerName();
        //Cookie::queue(Cookie::forget($rememberTokenName)); // 删除cookie 这样才能完全删除
        //Auth::user();
        session()->flash('success', '欢迎回来！');
        //return redirect()->route('home',[Auth::user()]);

        return redirect()->route('home');
      } else {
        session()->flash('email_no_pwd', '邮箱或密码错误！');
        return redirect()->back()->withInput();
      }
    } else {

      
      $view = 'users.email.confirm';
      $subject = "感谢注册 TKKStore 平台！请确认你的邮箱。";

      $this->sendEmailConfirmationTo($view, $user, $subject);
      session()->flash('success', '你的账号未激活,验证邮件已发送到你的注册邮箱上，请注意查收。');
    
      //dd($activation_token);
      return  redirect()->route('show_verify',['user' =>$user->id] );
      //return view('users.email.verify',compact('email'));
    }
 
  }

  public function login_out(Request $request)   // 退出登录
  {   


    Auth::logout();
    //dd($request ->cookie());
    session()->flash('success', '您已成功退出！');

    if ($request->ajax()) {
      return [];
    }
    //dd($request->session());
    return redirect()->route('login');
  }

  /* 邮箱认证 */

  public function show_verify(User $user) // 验证界面
  {      
    
    return view('users.email.verify',compact('user'));
  }
  public function second_send_email(User $user)      // 没有收到，再次发送
  {   

    //dd($user);
    //dd($token);
    //dd(Auth::user());
    if($user->activated){
      session()->flash('success', '你的账号已激活！');
      return route('root');
    }

    $view = 'users.email.confirm';
    $subject = "感谢注册 TKKStore 平台！请确认你的邮箱。";
    $this->sendEmailConfirmationTo($view, $user, $subject);
    session()->flash('success', '新的验证链接已发送到你的邮箱。');
    
    $activation_token=$user->activation_token;
    return view('users.email.verify',compact('user'));
  }
  protected function sendEmailConfirmationTo($view, $user, $subject)   // 自定义发送邮箱
  {
    //dd($user->email);
    //$view = 'users.email.confirm';

    $data = compact('user');

    $to =  $user->email;
    //$subject = "感谢注册 TKKStore 平台！请确认你的邮箱。";

    Mail::send($view, $data, function ($message) use ($to, $subject) {
      $message->to($to)->subject($subject);
    });
  }
  public function signup_verify($token,Request $request)    // 邮箱激活
  {
    
    $user = User::where('activation_token', $token)->where('email',$request->email)->firstOrFail();
    
    //dd($user);


    $user->activated = true;
    $user->activation_token = null;
    $user->email_verified_at = now();
    $user->save();

    Auth::login($user);
    session()->flash('success', '恭喜你，账号激活成功！');
    return redirect()->route('home', [$user]);
  }


  /* 重设密码 */

  public function password_send_email()   // 发送邮件
  {      
    return view('users.reset_password.send_email');
  }

  public function verify_password_send_email(Request $request)  // 处理发送邮件
  {     
    $credentials = $this->validate($request, [
      'email' => ['required', 'regex:/^[a-zA-Z\d]{8,}@qq.com$/', 'max:32', 'exists:users,email'],

    ], [
      'email.regex' => '请填写你的QQ邮箱！'
    ]);

    if ($credentials) {
      $user = User::where('email', $request->email);
      $data = $user->first();

      if ($data->activation_token == null) {
        $user->update(['activation_token' => Str::random(10)]);     // 重写生成
      }

      //dd($user);
      $view = 'users.email.reset_password';
      $subject = "重设密码通知！请确认你的邮箱！";
      $this->sendEmailConfirmationTo($view, $data, $subject);

      session()->flash('success', '密码重置邮件已发送！ ');

      return redirect()->route('password_send_email');
    }
    return view('users.reset_password.send_email');
  }

  public function reset_password($token, Request $request)  // 重设密码页
  {     

    //dd($request->all());
    $email = $request->email;

    return view('users.reset_password.reset_login', compact('email', 'token'));
  }

  public function verify_reset_password(Request $request)
  {
    $credentials = $this->validate($request, [
      'email' => ['required', 'regex:/^[a-zA-Z\d]{8,}@qq.com$/', 'between:3,25', 'exists:users,email'],
      'password' => ['required', 'between:6,32', 'confirmed']
    ], [
      'email.regex' => '请填写你的QQ邮箱！',
      'password.confirmed' => '两次密码不一致，请重新填写！!',
    ]);

    $email = $request->email;
    $token = $request->token;

    $user = User::where('email', $email)->where('activation_token', $token)->first();     // 令牌和账号必须一致

    if ($user == null) {
      session()->flash('error', '邮箱或令牌错误！');
      return view('users.reset_password.reset_login', compact('email', 'token'));
    }

    if($user->activated){     // 判断是否激活，未激活账号还需要token
      $user->update([
        'activation_token' => null,
        'password' => password_hash($request->password, PASSWORD_DEFAULT)
      ]);
    }else{    // 未激活
      $user->update([
        'activation_token' => Str::random(10),
        'password' => password_hash($request->password, PASSWORD_DEFAULT)
      ]);
    }
   
    session()->flash('success', '密码修改成功！');
    return redirect()->route('login');;
  }
}
