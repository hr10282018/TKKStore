<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式
use App\Models\Good;

class Order extends Model
{
  
  use DefaultDatetimeFormat;

  // 卖家状态
  const seller_cancel_order = 0;        // 取消订单
  const seller_confirm_order = 1;       // 确认发送
  const seller_pending_order = 2;   // 默认-待处理(没取消没确认)
  //const seller_outdate_prder=3;     // 订单超时，

  // 买家状态
  const buyer_cancel_order = 0;        // 取消订单
  const buyer_refuse_order = 1;         // 核对拒绝
  const buyer_confirm_order = 2;       // 核对确认
  const buyer_pending_order = 3;   // 默认-待处理(未取消未核对)
  const buyer_outdate_order=4;     // 买家订单超时， 

  // 支付方式
  const payment_wechat = 0;   // 默认-微信
  const payment_alipay = 1;   // 支付宝
  const payment_cash = 2;   // 现金
  const payment_other = 3;   // 其他


  // 软删
  const not_deleted=0; // 未删
  const is_deleted=1; // 已删

  // 买家订单超时时间-3天，单位s
  const buyer_outdate_order_in_seconds= 3*60*60*24;

  protected $fillable = [
    'no',
    'goods_id',
    'booking_id',
    'user_id',
    'buyer_id',
    'seller_state',
    'buyer_state',
    'reason',
    'payment_amount',
    'payment_method',
    'remark',
    'is_delete',
  ];


  public static function boot() // boot-用户模型类完成初始化之后进行加载
  {
    parent::boot();

    static::creating(function ($order) {       // creating-写入数据库之前触发
      if (!$order->no) {   // 如果 no字段空
        $order->no = static::createNo($order);

        if (!$order->no) {    // 重复订单号，则不插入
          return false;
        }
      }
    });
  }


  public static function createNo($order)
  {    // 生成订单号：时间+随机6位数字+商品id

    $timeStamp = date('YmdHis');   // 当前时间

    // $no = '20220409152119167587';

    $no = $timeStamp.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT).$order->id; // 不到6位则补0
    if (!static::query()->where('no', $no)->exists()) {    // 判断是否已存在
      return $no;
    }

    return false;
  }


  // 一个订单属于一个用户
  public function user()
  {
    return $this->belongsTo(User::class);   // 卖家id(user_id)
  }
  public function buyer()
  {
    return $this->belongsTo(User::class, 'buyer_id');  // 指定 买家id字段
  }

  
  // 一个订单 属于 一个商品
  public function goods(){
    return $this->belongsTo(Good::class,'goods_id');
  }
  // 订单的 已出售商品 
  public function soldGoods(){
    return $this->belongsTo(Good::class,'goods_id')->where('state',Good::goods_state_in_sold);
  }


  // 一个订单属于一个 预定
  public function boookings(){
    return $this->belongsTo(Booking::class,'booking_id');
  }
  


}
