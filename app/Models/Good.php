<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class Good extends Model
{

  use DefaultDatetimeFormat;
  use Traits\HotGoodsHelper;    // 热度商品


  protected $fillable = [
    'title', 'description', 'image', 'state', 'old_price', 'price', 'category_id', 'reply_count',
    'view_count', 'user_id','tags'
  ];

  public function user()
  {   // 命名有要求，不然出现bug
    return $this->belongsTo(User::class);   //一个商品属于一个用户
  }
 

  public function category()
  {
    return $this->belongsTo(Category::class);   // 一个商品属于一个分类
  }

  public function comments()
  {
    return $this->hasMany(Comment::class,'goods_id');     // 一个商品有多个评论 ，需要指定字段名，默认是(good_id)
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class,'goods_id')->orderBy('created_at','desc');     // 一个商品有多个预订  时间降序
  }

  // 一个商品有多个标签
  
}

