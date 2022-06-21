<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class GoodTag extends Model
{

  use DefaultDatetimeFormat;

  protected $fillable = [
    'name'
  ];  


  


  // 一个标签属于多个商品
  

}
