<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  protected $fillable = [
    'goods_id', 'user_id', 'buyer_id', 'user_state', 'reason'
  ];

  // 一个预订属于一个用户
  public function user()
  {   
    return $this->belongsTo(User::class);   // 默认卖家id(user_id)
  }
  public function buyer()
  {  
    return $this->belongsTo(User::class, 'buyer_id');  // 指定买家id的字段
  }


  // 一个预订属于一个商品
  public function goods()
  { 
    return $this->belongsTo(Good::class);
  }
    

}
