<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Carbon\Carbon;

class OverTimeOrder implements ShouldQueue    // 类放入队列执行，不是立即执行
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $order;

  // public $tries=2;   // 出错后执行次数
  // --delay=1    // 延迟多少秒 执行

  //private $dalay=2;
  //private $tries=2;

  public function __construct(Order $order,$delay) 
  {
    $this->order=$order;    // 赋值order
    $this->delay($delay);   // 延迟时间，单位s
    
  }
 
  // 当队列处理器从队列取任务，调用handle
  public function handle()
  {

    // 判断订单状态：卖家发送，买家待回复。 
    if($this->order->seller_state == Order::seller_confirm_order && $this->order->buyer_state == Order::buyer_pending_order){    
      
      //var_dump('相差s：'.$$diff_in_days);
      // 用订单的修改时间（表示距离上一次操作已经过了多久）和当前时间比较
      $diff_in_minutes=Carbon::parse($this->order->updated_at)->diffInMinutes(Carbon::now(), false);    
      // 再判断时间，到时间才执行
      if($diff_in_minutes >= Order::buyer_outdate_order_in_seconds ){
        $this->order->update(['buyer_state' => Order::buyer_outdate_order]);  // 买家状态改为超时
        
      }
    }

  }






  
  // 任务失败
  public function failed(Exception $exception)
  {
    // var_dump($exception->getMessage()); 
  }
  
}
