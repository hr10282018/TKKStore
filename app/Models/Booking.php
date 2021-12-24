<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

  protected $fillable = [
    'goods_id', 'user_id', 'buyer_id', 'user_state', 'reason'
  ];


  public function user(){   // 一个预订属于一个用户
    return $this->belongsTo(User::class);   // 默认卖家id(user_id)
  }
  public function buyer(){   // 一个预订属于一个用户
    return $this->belongsTo(User::class,'buyer_id');  // 指定买家id的字段
  }

  public function goods(){// 一个预订属于一个商品
    return $this->belongsTo(Good::class);
  }

}
