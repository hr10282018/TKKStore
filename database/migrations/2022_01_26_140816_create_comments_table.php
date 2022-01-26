<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{

  public function up()
  {
    Schema::create('comments', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('goods_id')->index();    // 评论商品id
      //$table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');

      $table->unsignedBigInteger('user_id')->index();     // 评论用户id
      //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->text('content');    // 评论内容
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('comments');
  }
}
