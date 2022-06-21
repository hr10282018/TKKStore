<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{

  public function up()
  {
    Schema::create('goods', function (Blueprint $table) {

      $table->increments('id');

      $table->unsignedInteger('category_id')->unsigned()->index();   // 商品类别id
      
      //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');// 外键

      $table->unsignedInteger('user_id')->unsigned()->index();   // 商品所属用户id

      $table->string('title', 255);

      $table->string('description',512);    // 商品描述
      
      $table->string('image',512);  // 商品图片

      $table->tinyInteger('state');   // 商品状态(0-未发布，1-审核中，2-正在售卖，3-被预订，4-已出售)

      $table->decimal('price', 5, 1);  // 商品价格，最大9999.9

      $table->decimal('old_price', 5, 1)->nullable();  // 商品原价，最大9999.9

      $table->unsignedInteger('view_count')->unsigned()->default(0);   // 浏览量

      $table->unsignedInteger('reply_count')->unsigned()->default(0);   // 评论数量

      
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('goods');
  }
}
