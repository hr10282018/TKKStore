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

      $table->unsignedBigInteger('buyer_id')->index();     // 预订者id
      //$table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');

      $table->string('user_state', 2)->nullable();   // 卖家是否同意出售  0-拒绝 1-同意
      $table->string('reason')->nullable();   // 拒绝的原因
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('bookings');
  }

}
