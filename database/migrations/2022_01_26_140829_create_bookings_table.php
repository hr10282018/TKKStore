<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{

  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->unsignedBigInteger('goods_id')->index();    // 商品id
      //$table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');

      $table->unsignedBigInteger('user_id')->index();     // 商品所属用户id
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->unsignedBigInteger('booker_id')->index();     // 预订者id  booker_id
      //$table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');

      $table->string('user_state', 2)->nullable();   // 卖家是否同意出售  0-拒绝 1-同意 2-未同意未拒绝(预定ing)

      //$table->string('booking_number', 2)->nullable();   // 预定次数

      $table->string('reason')->nullable();   // 拒绝的原因 255
      
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('bookings');
  }

}
