<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVisiblesTable extends Migration
{

  public function up()
  {
    Schema::create('user_visibles', function (Blueprint $table) {
      $table->id();
      // 个人信息
      $table->unsignedBigInteger('user_id');    // 用户id
      $table->boolean('v_email')->default(true);     // 邮箱-默认可见
      $table->boolean('v_phone')->default(true);
      $table->boolean('v_university')->default(true);
      $table->boolean('v_faculty')->default(true);
      $table->boolean('v_number')->default(true);
      $table->boolean('v_r_name')->default(true);
      
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('user_visibles');
  }
}
