<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Good;
use Illuminate\Http\Request;
use Auth;

class BookingsController extends Controller
{


  // 获取预定次数
  public function ajax_booking_count(Good $goods){
    $booking_count=Booking::where('goods_id',$goods->id)->where('booker_id',Auth::user()->id)->get()->count();

    return $booking_count;
  
  }

  // 预定
  public function ajax_booking_goods(Good $goods,$user_id,Booking $booking){    // 处理预订商品
    //dd($request->all());
    //dd(Auth::user()->id);
    if($goods->state == 2){
      $booking->booker_id=Auth::user()->id;    // 
      $booking->user_id=$user_id;    // 卖家
      $booking->goods_id=$goods->id;   //商品id
      $booking->user_state=2;    // 用户状态- 2卖家未回复
      $booking->save();
      Good::where('id',$goods->id)->update(['state'=>3]);    // 状态为预定中 3
    }else{

    }
    return [];
  }

  // 取消预定
  public function ajax_cancel_booking(Good $goods){

    $affected=Booking::where('goods_id',$goods->id)
    ->where('booker_id',Auth::user()->id)
    ->orderBy('created_at','desc')
    ->first()
    ->update(['user_state' => 3]);      // 3-取消预定
    
    Good::where('id',$goods->id)->update(['state'=>2]);   // 商品状态改为 2
    return [];
  }
}
