<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式
use Auth;

class User extends Authenticatable
{
  //use Notifiable;
  use DefaultDatetimeFormat;

  use Notifiable {
    notify as protected BookingNotify;    // 重命名，需要重写
  }


  protected $fillable = [
    'name', 'email', 'password', 'avatar', 'activated', 'activation_token',
    'sex', 'signature', 'phone',  'faculty', 'number', 'r_name',      // 禁止修改学校 
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];


  public static function boot() // boot-用户模型类完成初始化之后进行加载
  {
    parent::boot();

    static::creating(function ($user) {
      $user->activation_token = Str::random(10);  // 生成邮箱令牌
    });
  }

  


  // 预定通知-重写notify，未读+1
  public function notify($instance)
  {
    
    // if ($this->id == Auth::id()) {
    //   return;
    // }

    // 判断是否有该方法，是数据库类型通知才提醒
    if (method_exists($instance, 'toDatabase')) {
      $this->increment('notification_count');       // 未读+1
    }

    $this->BookingNotify($instance);
  }


  // 消除已读
  public function ClearRead(){
    $this->notification_count = 0;
    $this->save();
    $this->unreadNotifications->markAsRead();   // 通过更新 read_at 时间
  }
  


  public function goods()
  {
    return $this->hasMany(Good::class);     // 一个用户有多个商品
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);     // 一个用户有多个评论
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class, 'booker_id');     // 一个买家有多个预订
  }
  public function bookingsUser()
  {
    return $this->hasMany(Booking::class, 'user_id');     // 一个卖家有多个预订通知
  }

  public function userVisibles()       // 一个用户有一个 可见设置
  {
    return $this->hasOne(UserVisible::class);
  }


  // 一个用户有多个订单
  public function buyerOrders()
  {
    return $this->hasMany(Order::class, 'buyer_id')->where('is_delete',Order::not_deleted);     // 一个买家有多个订单
  }
  public function sellerOrders()
  {
    return $this->hasMany(Order::class, 'user_id');     // 一个卖家有多个订单
  }
}
