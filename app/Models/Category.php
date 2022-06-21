<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class Category extends Model
{
  use DefaultDatetimeFormat;
  
  protected $fillable = [
    'name', 'description'
  ];


  public function goods()
  {
    return $this->hasMany(Good::class);     // 一个分类有多个商品
  }



  
}
