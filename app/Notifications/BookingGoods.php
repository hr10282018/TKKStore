<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;

class BookingGoods extends Notification // implements ShouldQueue
{
  use Queueable;

  public $booking;

  // 初始化 预定模型实例
  public function __construct(Booking $booking)
  {
    $this->booking = $booking;
  }

  // 通知在那个频道发送
  public function via($notifiable)
  {
    return ['database'];    // 数据库频道
  }

  public function toDatabase($notifiable)
  {
    
    // 存入数据库
    return [
      'booking_id' => $this->booking->id,     // 预定id
      'booker_id' => $this->booking->booker_id,   // 预定用户id
      'booker_name' => $this->booking->buyer->name,        // 预定用户name
      'booker_avatar' => $this->booking->buyer->avatar,    // 预定用户头像
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
