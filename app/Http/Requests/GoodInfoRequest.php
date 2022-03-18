<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodInfoRequest extends Request
{

  // public function authorize()
  // {
  //     return false;
  // 
  public function rules()
  {
    return [
      'title'  => ['required'],

      'description' =>  ['required'],

      'price' =>  ['required'],

      'old_price' =>  ['required'],

      //'goods_img' =>  ['required'],

    ];
  }

  public function messages()
  {
    return [
      //'goods_img.dimensions' => '图片尺寸太小，宽度最少316，高度最少418'
    ];
  }
}

