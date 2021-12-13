<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

  protected $fillable = [
    'title', 'description', 'image','state','old_price','price', 'category_id', 'reply_count',
    'view_count', 'user_id',
  ];

  public function user(){
    return $this->belongsTo(User::class);   //一个商品属于一个用户
  }

  public function category(){
    return $this->belongsTo(Category::class);   // 一个商品属于一个分类
  }

}
