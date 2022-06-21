<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;    // 后台日期格式

class Good extends Model
{

  use DefaultDatetimeFormat;
  use Traits\HotGoodsHelper;    // 热度商品

  
  const goods_state_in_release=0;     // 预发布
  const goods_state_in_check=1;       // 审核中
  const goods_state_in_selling=2;    // 出售中
  const goods_state_in_booking=3;    // 预定中
  const goods_state_in_sold=4;       // 已出售

  const user_view_goods= 86400;    // 用户浏览商品 生存时间 s
  
  // 审核不通过原因
  public static $checkReason =[
    '商品信息不合格',
    '商品图片不合格',
    '其他'
  ];

  
  protected $fillable = [
    'title', 'description', 'image', 'state', 'old_price', 'price', 'category_id', 'reply_count',
    'view_count', 'user_id','tags'
  ];


  protected $casts = [
    'image' => 'json',
  ];

  public function ImageToArray(){
    $this->image=explode(',', $this->image);
    return $this->image;
  }


  // 判断商品当前状态-审核中
  public function goods_state_is_check($id){
    $state=Good::where('id',$id)->value('state');
    
    if($state == self::goods_state_in_check) return true;
    else return false;
    
  }

  public function goods_state_is_check2(){
    
    if($this->state == self::goods_state_in_check) return true;
    else return false;
    
  }


  public function user()
  {   // 命名有要求，不然出现bug
    return $this->belongsTo(User::class);   //一个商品属于一个用户
  }
 

  public function category()
  {
    return $this->belongsTo(Category::class,'category_id');   // 一个商品属于一个分类
  }

  public function comments()
  {
    return $this->hasMany(Comment::class,'goods_id');     // 一个商品有多个评论 ，需要指定字段名，默认是(good_id)
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class,'goods_id')->orderBy('created_at','desc');     // 一个商品有多个预订  时间降序
  }

  public function orders(){
    return $this->hasMany(Order::class,'goods_id')->where('is_delete',Order::not_deleted);   // 一个商品多个订单 (包括软删)
  }
  
  
}

