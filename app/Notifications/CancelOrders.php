<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelOrders extends Notification
{
  use Queueable;

  public $order;
 
  public function __construct(Order $order)
  { 
    $this->order = $order;
  }

 
  public function via($notifiable)
  {
    return ['database'];
  }

  public function toDatabase($notifiable)
  {
    
    // 存数据
    return [
      'no' => $this->order->no,     // 订单no

      'buyer_id' =>$this->order->buyer_id, //买家id
      'buyer_name' => $this->order->buyer->name,   // 买家 名称
      'buyer_avatar' =>  $this->order->buyer->avatar, // 买家头像

      'seller_id' =>  $this->order->user_id,    // id
      'seller_name' => $this->order->user->name,   // 卖家 名称
      'seller_avatar' =>  $this->order->user->avatar, // 卖家头像

      'seller_state' => $this->order->seller_state,   // 卖家状态，谁取消订单

      'order_goods_id' =>  $this->order->goods->id,  // 订单商品ID
      'order_goods_title' => $this->order->goods->title,        // 订单商品标题
    ];
  }
  
  // public function toMail($notifiable)
  // {
  //   return (new MailMessage)
  //     ->line('The introduction to the notification.')
  //     ->action('Notification Action', url('/'))
  //     ->line('Thank you for using our application!');
  // }

 
  // public function toArray($notifiable)
  // {
  //   return [
  //     //
  //   ];
  // }

}
