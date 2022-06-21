<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersVisibles extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('user_visibles', function (Blueprint $table) {

      // 我购买的商品
      $table->boolean('v_buy_booking_goods')->default(true);   // 预定他人的商品
      $table->boolean('v_buy_sale_goods')->default(true);       // 购买过他人的商品(已下单)
      
      // 我发布的商品
      $table->boolean('v_booking_goods')->default(true);   // 商品不同的状态
      $table->boolean('v_sale_goods')->default(true);
      $table->boolean('v_saled_goods')->default(true);

      // 个人评论
      $table->boolean('v_comment')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('user_visibles', function (Blueprint $table) {
      //
      $table->dropColumn(['v_buy_booking_goods', 'v_buy_sale_goods', 'v_booking_goods','v_sale_goods','v_saled_goods','v_comment']);
    });
  }
}
