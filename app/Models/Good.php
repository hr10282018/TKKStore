<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class Good extends Model
{

  use DefaultDatetimeFormat;

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
    return $this->hasMany(Comment::class);     // 一个商品有多个评论
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class);     // 一个商品有多个预订
  }

}
