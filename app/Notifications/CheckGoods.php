<?php

namespace App\Notifications;

use App\Models\Good;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckGoods extends Notification
{
  use Queueable;

  public $goods;
  public $data;

  public function __construct(Good $goods,$data)
  {
    $this->goods=$goods;
    $this->data=$data;
  }

 
  public function via($notifiable)
  {
    return ['database'];
  }

  
  public function toDatabase($notifiable)
  {
    
    // 存入数据库里的数据-json
    return $this->data;
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
