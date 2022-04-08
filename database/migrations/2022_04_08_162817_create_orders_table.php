<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{

  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id');    // UNSIGNED INT
      $table->string('no', 255);   // 订单编号
      $table->unsignedBigInteger('goods_id'); // 订单商品
      $table->unsignedBigInteger('user_id');   // 卖家
      $table->unsignedBigInteger('buyer_id');   // 买家
      $table->tinyInteger('seller_state');       // 卖家状态 0-取消订单 1-确认发送 2-未取消未确认(处理中)  
      $table->tinyInteger('buyer_state');       // 买家状态  0-取消订单 1-核对拒绝 2-核对确认- 3-未取消未核对(处理中)                      
      $table->string('reason', 32);   // 买家 核对拒绝原因
      $table->decimal('payment_amount', 5, 1);   // 支付金额
      $table->tinyInteger('payment_method');  // 支付方式 0-微信 1-支付宝 2-现金 3-其他
      $table->string('remark', 255);   // 订单备注

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('orders');
  }
}
