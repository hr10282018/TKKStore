<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllReferences extends Migration
{

  public function up()
  {
    Schema::table('goods', function (Blueprint $table) {

      // 用户id
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');     // 严格删除
      // 商品分类id 
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });


    Schema::table('comments', function (Blueprint $table) {

      //  user_id
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      // goods_id
      $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');
    });

    Schema::table('user_visibles', function (Blueprint $table) {

      //  user_id
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });


    Schema::table('bookings', function (Blueprint $table) {

      //  user_id
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      //  booker_id
      $table->foreign('booker_id')->references('id')->on('users')->onDelete('cascade');
      // goods_id
      $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');
    });


    Schema::table('orders', function (Blueprint $table) {

      //  user_id
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      //  user_id
      $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
      // goods_id
      $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');
      // booking_id
      $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');

    });


  }


  public function down()
  {
    Schema::table('goods', function (Blueprint $table) {
      // 移除外键
      $table->dropForeign(['user_id']);
      $table->dropForeign(['category_id']);
    });

    Schema::table('comments', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      $table->dropForeign(['goods_id']);
    });

    Schema::table('user_visibles', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      
    });

    Schema::table('bookings', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      $table->dropForeign(['booker_id']);
      $table->dropForeign(['goods_id']);
    });

    Schema::table('orders', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
      $table->dropForeign(['buyer_id']);
      $table->dropForeign(['goods_id']);
      $table->dropForeign(['booking_id']);
    });


  }
}
