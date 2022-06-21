<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{

  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {

      $table->increments('id');

      $table->unsignedInteger('goods_id')->index();    // 商品id
      //$table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');

      $table->unsignedInteger('user_id')->index();     // 商品所属用户id
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->unsignedInteger('booker_id')->index();     // 预订者id  booker_id
      //$table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');

      $table->tinyInteger('user_state')->default(2);   // 用户状态- 0-卖家拒绝，1-卖家同意 2-卖家未同意未拒绝(买家预定中)  3-买家取消

      //$table->string('booking_number', 2)->nullable();   // 预定次数

      $table->string('reason',32)->nullable();   // 卖家拒绝的原因 
      
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('bookings');
  }

}
