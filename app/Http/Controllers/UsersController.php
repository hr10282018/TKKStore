<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

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

    return redirect()->route('login_show');  // 先转到主页
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





  
}
