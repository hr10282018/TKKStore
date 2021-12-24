<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Good;
use Illuminate\Http\Request;
use Auth;

class BookingsController extends Controller
{


  public function booking_goods(Good $good,$goods_id,Request $request,Booking $booking){    // 处理预订商品
    //dd($request->all());
    //dd(Auth::user()->id);

    $booking->buyer_id=Auth::user()->id;    // 买家
    $booking->user_id=$request->user_id;    // 卖家
    $booking->goods_id=$goods_id;   //商品id
    $booking->save();


    Good::where('id',$goods_id)->update(['state'=>2]);

    return redirect()->back()->with('success', '预订成功！ 请等待卖家回应 ^_^');
  }


}
