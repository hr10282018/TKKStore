<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
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
    return $this->belongsTo(Good::class);
  }
    

}
