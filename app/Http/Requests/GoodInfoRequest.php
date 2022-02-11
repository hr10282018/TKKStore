<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodInfoRequest extends Request
{

  // public function authorize()
  // {
  //     return false;
  // }


  public function rules()
  {
    return [
      'title'  => ['required','max:255'],

      'description' =>  ['required'],

      'price' =>  ['required','digits_between:0.1,9999.9'],

      'old_price' =>  ['required','digits_between:1,4'],

      'goods_img' =>  ['required','dimensions:min_width=316,min_height=418',
                        // function ($attribute, $value, $fail) {
                        //   //$user=User::where('email',$value)->first();
                        //   //return $fail(Auth::user()->name);
                        //   for()
                        //   if($user && $user->email != Auth::user()->email){
                        //     return $fail('该邮箱已被注册！');
                        //   }
                        // },
                      ],

    ];
  }

  public function messages()
  {
    return [
      //'goods_img.dimensions' => '图片尺寸太小，宽度最少316，高度最少418'
    ];
  }
}
