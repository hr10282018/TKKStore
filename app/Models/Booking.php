<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class Booking extends Model
{
  use DefaultDatetimeFormat;

  // 用户状态

  const seller_refuse_booking = 0;  // 卖家拒绝
  const seller_agree_booking = 1;   // 卖家同意
  const seller_processing_booking = 2; // 卖家未同意未拒绝(买家预定中)
  const buyer_cancel_booking = 3;  // 买家取消

  protected $fillable = [
    'goods_id', 'user_id', 'booker_id', 'user_state', 'reason'
  ];

  // 一个预订属于一个用户
  public function user()
  {   
    return $this->belongsTo(User::class);   // 卖家id(user_id)
  }
  public function buyer()
  { 
    return $this->belongsTo(User::class, 'booker_id');  // 指定预定用户id的字段
  }


  // 一个预订属于一个商品
  public function goods()
  { 
    return $this->belongsTo(Good::class,'goods_id');
  }

  public function goodsSearch($content)
  { 
    return $this->belongsTo(Good::class,'goods_id')->where('title','like',$content)->orWhere('description','like',$content);
  }

  public function goods_sort()
  { 
    return $this->belongsTo(Good::class,'goods_id')->orderBy('created_at','desc');
  }



}
