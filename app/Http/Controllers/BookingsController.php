<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Good;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use App\Exceptions\InvalidRequestException;

class BookingsController extends Controller
{


  // 获取预定次数
  public function ajax_booking_count(Good $goods)
  {
    $booking_count = Booking::where('goods_id', $goods->id)->where('booker_id', Auth::user()->id)->get()->count();

    return $booking_count;
  }

  // 判断 未处理事项
  public function ajax_operate_premise()
  {

    // 预定未处理
    $booking['booking'] = Booking::where('user_id', Auth::user()->id)->where('user_state', Booking::seller_processing_booking)->exists();

    // 订单未处理
    $order['order'] = Order::where('user_id', Auth::user()->id)->where('seller_state', Order::seller_pending_order)->orWhere(function ($query) {
      $query->where('buyer_id', Auth::user()->id)->where('buyer_state', Order::buyer_pending_order)->where('seller_state', Order::seller_confirm_order);
    })->exists();


    return [$booking, $order];
  }


  // 预定
  public function ajax_booking_goods(Good $goods, $user_id) // 处理预订商品
  {    
    
    //dd($request->all());
    //dd(Auth::user()->id);
    //$is_delete=Good::where('id',$goods)->exists();

    // if(!$goods){
    //   return response()->json(['msg' => '错误'], 404);
    // }

    if ($goods->state == Good::goods_state_in_selling) {      // 出售
      $res = Booking::create([
        'goods_id' => $goods->id,   //商品id
        'user_id' => $user_id,    // 卖家
        'booker_id' => Auth::id(),    // 买家
        'user_state' => Order::seller_pending_order,             // 订单状态-卖家未回复
      ]);

      Good::where('id', $goods->id)->update(['state' => Good::goods_state_in_booking]);    // 商品状态-预定中

    } else if ($goods->state == Good::goods_state_in_booking) {      // 预定中

      throw new InvalidRequestException('抱歉，该商品已被预定！', 401);
    }

    return [];
  }

  // 取消预定
  public function ajax_cancel_booking(Good $goods)
  {

    if ($goods->state == Good::goods_state_in_selling) {

      throw new InvalidRequestException('抱歉，你已取消预定！', 401);
    }
    if ($goods->bookings->first()->user_state == Booking::seller_agree_booking) {

      throw new InvalidRequestException('抱歉，买家已同意预定！', 401);
    }

    $affected = Booking::where('goods_id', $goods->id)
      ->where('booker_id', Auth::user()->id)
      ->orderBy('created_at', 'desc')
      ->first()
      ->update(['user_state' => Booking::buyer_cancel_booking]);      // 3-取消预定

    Good::where('id', $goods->id)->update(['state' => Good::goods_state_in_selling]);   // 商品状态 出售
    return [];
  }

  public function agree_booking(Booking $booking_id)
  {    // 处理接受预订 同意预定

    //dd($booking_id);
    if ($booking_id->user_state == Booking::buyer_cancel_booking) {
      throw new InvalidRequestException('抱歉，买家已取消预定！', 401);
    }


    Booking::where('id', $booking_id->id)->first()->update(['user_state' => Booking::seller_agree_booking]);  // 

    // 生成订单
    $order = Order::create([
      'goods_id' => $booking_id->goods_id,
      'booking_id' => $booking_id->id,
      'user_id' => $booking_id->user_id,    // 卖家
      'buyer_id' => $booking_id->booker_id,    // 买家
      'seller_state' => Order::seller_pending_order,  // 卖家待处理     
      'buyer_state' =>  Order::buyer_pending_order,  // 买家待处理
      'reason' => '',
      'payment_amount' => $booking_id->goods->price, // 售价
      'payment_method' => Order::payment_wechat, // 微信
    ]);

    // // 订单号重复，抛出异常
    // if (!$order->no) {
    //   //return response()->json(['msg' => '系统出错！请在试一次 ^_^'], 500);
    // }

    
    return [];
  }

  // 处理拒绝预订
  public function refuse_booking(Booking $booking_id, Request $request)
  {   

    
    if ($booking_id->user_state == Booking::buyer_cancel_booking) {
      throw new InvalidRequestException('抱歉，买家已取消预定！', 401);
    }

    //$bookings=Booking::where('id',$booking_id)->first();
    $booking_id->goods->update(['state' => Good::goods_state_in_selling]);     // 修改商品状态

    $booking_id->update(['user_state' => Booking::seller_refuse_booking, 'reason' => $request->refuse_reason]);   // 修改用户状态
    return [];
  }
}
