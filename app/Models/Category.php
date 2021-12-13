<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  protected $fillable = [
    'name', 'description', 'count'
  ];

  public function category_goods(){
    return $this->hasMany(Good::class);     // 一个分类有多个商品
  }

}
