<?php

namespace App\Http\Requests;

use App\Models\User;
use Auth;
class UserInfoRequest extends Request
{

  // public function authorize()
  // {
  //   return false;
  // }

  // 用户的个人信息
  public function rules()
  {
    return [
      'name'  =>  ['required','between:3,25',
                  function ($attribute, $value, $fail) {
                    $user=User::where('name',$value)->first();
                    //return $fail(Auth::user()->name);
                    if($user && $user->name != Auth::user()->name){
                      return $fail('该用户名已被注册！');
                    }
                  },
                  ],
      'email' =>  ['required','regex:/^[a-zA-Z\d]{8,}@qq.com$/',
                  function ($attribute, $value, $fail) {
                    $user=User::where('email',$value)->first();
                    //return $fail(Auth::user()->name);
                    if($user && $user->email != Auth::user()->email){
                      return $fail('该邮箱已被注册！');
                    }
                  },
                  ],
      'signature' =>  ['max:50'],
      'phone' =>  ['nullable','integer']
    ];
  }

  public function messages()
  {
    return [
      'phone.integer' => '手机号码 必须是整数。'
    ];
  }

}
