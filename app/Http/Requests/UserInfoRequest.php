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
                      $user=User::where('email',$value)->exists();
                      //return $fail(Auth::user()->name);
                      if($user && $value != Auth::user()->email){
                        return $fail('该邮箱已被注册！');
                      }
                    },
                  ],
      'signature' =>  ['max:80'],
      'phone' =>  ['nullable','integer'],
      
      'faculty' =>['nullable','max:32'],
      'number' =>['nullable','max:8','alpha_num'],    //字母或数字组成
      'r_name' =>['nullable','max:32'],
    ];
  }

  public function messages()
  {
    return [
      'phone.integer' => '手机号码 必须是整数。',
      'number.max' =>'学号不能大于 8个字符',
      'r_name.max' => '真实姓名不能大于 32个字符',
      'faculty.max' => '院系不能大于 32个字符',
    ];
  }

}
