<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Jobs\OverTimeOrder;
use App\Models\Booking;
use App\Models\Good;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\CancelOrders;


class OrdersController extends Controller
{
  

  // 卖家发送订单确认
  public function seller_send_order(Order $order,Request $request)
  {
    
    if($order->is_delete){
      throw new InvalidRequestException('抱歉，此订单已买家被取消！',401);
    }

    
    if($request->buyer_state == Order::buyer_refuse_order){   // 非第一次，买家拒绝
      $order->update([
      'payment_amount'=>$request->payment_amount,
      'payment_method'=>$request->payment_method,
      'remark'=>$request->remark,
      'seller_state' => Order::seller_confirm_order,   // 修改卖家状态-确认发送
      'buyer_state' => Order::buyer_pending_order      // 修改买家状态-待处理
      ]);
    }elseif($request->buyer_state == Order::buyer_pending_order){   // 第一次发送
      $order->update([
      'payment_amount'=>$request->payment_amount,
      'payment_method'=>$request->payment_method,
      'remark'=>$request->remark,
      'seller_state' => Order::seller_confirm_order   // 修改卖家状态-确认发送
      ]);
    }

    // 触发任务-超时订单(买家)
    $this->dispatch(new OverTimeOrder($order, Order::buyer_outdate_order_in_seconds));   // 放入默认队列
     
  
    //buyer_state
    return [];
  }

  // 卖家取消订单
  public function seller_cancel_order(Order $order)
  {

    if($order->is_delete){
      throw new InvalidRequestException('抱歉，此订单已买家被取消！',401);
    }

    $order->update([
      'seller_state' =>Order::seller_cancel_order,
      'is_delete' =>Order::is_deleted,
    ]);

    // 修改预定状态
    $order->boookings->update([
      'user_state' => Booking::seller_refuse_booking
    ]);

    // 商品状态
    $order->goods->update([
      'state' => Good::goods_state_in_selling
    ]);

    // 取消-订单通知
    $order->user->notify(new CancelOrders($order));   // 买家
    $order->buyer->notify(new CancelOrders($order));  // 卖家
    
    return [];
  }


  // 买家拒绝订单
  public function buyer_refuse_order(Order $order,Request $request)
  {

    if($order->is_delete){
      throw new InvalidRequestException('抱歉，此订单已卖家家被取消！',401);
    }

    $order->update([  
      'seller_state' =>Order::seller_pending_order,   // 卖家未处理
      'buyer_state' => Order::buyer_refuse_order,     // 买家拒绝
      'reason' => $request->refuse_reason,
    ]);

    return [$order->id];
  }

  // 买家同意订单
  public function buyer_confirm_order(Order $order)
  {

    $order->update(['buyer_state'=>Order::buyer_confirm_order]);
    $order->goods->update(['state'=>Good::goods_state_in_sold]);

    return [];
  }

  // 买家取消订单
  public function buyer_cancel_order(Order $order)
  {

   
    if($order->is_delete){
      throw new InvalidRequestException('抱歉，此订单已卖家被取消！',401);
    }

    $order->update([
      'buyer_state' => Order::buyer_cancel_order,   // 买家取消
      'is_delete' =>Order::is_deleted       // 软删
    ]);
    
    // 修改预定状态
    $order->boookings->update([
      'user_state' => Booking::buyer_cancel_booking
    ]);

    // 商品状态
    $order->goods->update([
      'state' => Good::goods_state_in_selling
    ]);


    // 取消-订单通知
    $order->user->notify(new CancelOrders($order));   // 买家
    $order->buyer->notify(new CancelOrders($order));  // 卖家

    return [];

  }
}
