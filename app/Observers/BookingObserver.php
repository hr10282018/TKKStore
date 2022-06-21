<?php

namespace App\Observers;
use App\Models\Booking;
use App\Notifications\BookingGoods;

use Carbon\Carbon;

class BookingObserver
{


  // 插入数据库后触发(无更新)
  public function created(Booking $booking)
  {

    // echo('数据插入');
    // 通知 商品作者
    
    $booking->user->notify(new BookingGoods($booking));
    
  }


  // 插入前
  // public function creating(Booking $booking)
  // { 
    
    
  // }
}
