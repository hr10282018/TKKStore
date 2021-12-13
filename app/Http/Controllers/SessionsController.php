<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
//use Mail;
use Illuminate\Support\Facades\Mail;

class SessionsController extends Controller
{

  public function __construct()
  {
    $this->middleware('guest', [
      'only' => ['login','signup_verify']
    ]);

    $this->middleware('throttle:6,1')->only('signup_verify2');  //再次发送邮件限制访问频率1分钟6次
  }


   /* 登录处理 */

  public function login(){   // 登录界面
    return view('users.login');
  }
  public function login_check(Request $request,User $user){  // 登录信息
    $credentials = $this->validate($request, [
      'email' => ['required','regex:/.{6,}@qq.com/','max:255'],
      'password' => 'required'
    ],[
      'email.regex'=>'请填写您注册的QQ邮箱！'
    ]);

    if (Auth::attempt($credentials,$request->has('remember'))) {  // 第二个参数bool(记住我)

      if(Auth::user()->activated) {
        session()->flash('success', '欢迎回来！');
        //return redirect()->route('home',[Auth::user()]);
        return redirect()->route('home');
      }else{

        //dd(Auth::user()->activated);
        //Auth::logout();
        $user=Auth::user();
        //Auth::logout();

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '你的账号未激活,验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('show_verify');
      }

    } else{
      session()->flash('email_no_pwd', '邮箱或密码错误！');
      return redirect()->back()->withInput();
    }
  }
  public function login_out(){    // 退出登录
    Auth::logout();
    session()->flash('success', '您已成功退出！');
    return redirect('login');
  }

   /* 邮箱认证 */

  public function show_verify(){      // 验证界面
    return view('users.email.verify');
  }
  public function signup_verify2($token){   // 若没有收到，再次发送



    $user = User::where('activation_token', $token)->firstOrFail();
    //dd($token);
    //dd(Auth::user());
    $this->sendEmailConfirmationTo($user);
    session()->flash('success', '新的验证链接已发送到您的 E-mail。');
    return redirect()->route('show_verify');
  }
  protected function sendEmailConfirmationTo($user)   // 自定义发送邮箱
  {
    //dd($user->email);
    $view = 'users.email.confirm';
    $data = compact('user');
    $to =  $user->email;
    $subject = "感谢注册 TKK Store 平台！请确认你的邮箱。";

    Mail::send($view, $data, function ($message) use ($to, $subject) {
      $message->to($to)->subject($subject);
    });
  }
  public function signup_verify($token)    // 验证邮箱
  {
    $user = User::where('activation_token', $token)->firstOrFail();

    $user->activated = true;
    $user->activation_token = null;
    $user->save();
    //Auth::login($user);
    session()->flash('success', '恭喜你，激活成功！');
    return redirect()->route('home', [$user]);

  }





}
