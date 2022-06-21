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

      $table->unsignedInteger('goods_id')->index(); // 订单商品
      $table->unsignedInteger('booking_id')->index();   // 预定id

      $table->unsignedInteger('user_id')->index();   // 卖家
      $table->unsignedInteger('buyer_id')->index();   // 买家

      $table->tinyInteger('seller_state');       // 卖家状态 0卖家状态 0-取消订单 1-确认发送 2-未取消未发送(处理中)
      $table->tinyInteger('buyer_state');       // 买家状态 0-取消订单 1-核对拒绝 2-核对同意- 3-未取消未核对(处理中) 4-订单超时-自动确认

      $table->string('reason', 32);   // 买家 核对拒绝原因
      $table->decimal('payment_amount', 5, 1);   // 支付金额
      $table->tinyInteger('payment_method');  // 支付方式 0-微信 1-支付宝 2-现金 3-其他
      $table->string('remark', 255)->nullable();   // 订单备注
      $table->tinyInteger('is_delete')->default(0);   // 软删 0-未删 1-已删 。默认0

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('orders');
  }
}
