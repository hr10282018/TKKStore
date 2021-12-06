<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{


   /* 登录处理 */

  public function login_show(){   // 登录界面
    return view('users.login');
  }
  public function login_check(Request $request){  // 登录信息
    $credentials = $this->validate($request, [
      'email' => ['required','regex:/.{6,}@qq.com/','max:255'],
      'password' => 'required'
    ],[
      'email.regex'=>'请填写您注册的QQ邮箱！'
    ]);

    if (Auth::attempt($credentials,$request->has('remember'))) {  // 第二个参数bool(记住我)
      session()->flash('success', '欢迎回来！');
      return redirect()->route('home', [Auth::user()]);
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

}
