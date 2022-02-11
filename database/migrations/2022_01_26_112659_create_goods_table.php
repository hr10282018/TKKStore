<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{

  public function up()
  {
    Schema::create('goods', function (Blueprint $table) {

      $table->bigIncrements('id');
      $table->string('title', 255);
      $table->text('description');    // 商品描述
      $table->text('image');  // 商品图片
      $table->tinyInteger('state');   // 商品状态(0-未发布，1-发布且正在售卖，2-发布且被预订，3-发布且已出售)
      $table->decimal('price', 5, 1);  // 商品价格，最大9999.9
      $table->decimal('old_price', 5, 1)->nullable();  // 商品原价，最大9999.9
      $table->unsignedInteger('view_count')->unsigned()->default(0);   // 浏览量
      $table->unsignedInteger('reply_count')->unsigned()->default(0);   // 评论数量

      $table->unsignedInteger('category_id')->unsigned()->index();   // 商品类别id
      //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');// 外键

      $table->unsignedBigInteger('user_id')->unsigned()->index();   // 商品所属用户id
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('goods');
  }
}
