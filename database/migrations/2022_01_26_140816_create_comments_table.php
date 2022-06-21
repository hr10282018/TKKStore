<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{

  public function up()
  {
    Schema::create('comments', function (Blueprint $table) {

      $table->increments('id');

      $table->unsignedInteger('goods_id')->index();    // 评论商品id
      //$table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');

      $table->unsignedInteger('user_id')->index();     // 评论用户id
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->string('content',255);    // 评论内容
      //$table->string('content', 512);

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('comments');
  }
}
