<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {

      $table->increments('id');

      $table->string('name',32);    // 名称

      $table->string('r_name',16)->nullable();   // 真实姓名

      $table->string('email',32)->unique();    // 邮箱

      $table->timestamp('email_verified_at')->nullable();   // 邮箱认证时间

      $table->string('password',255);   // 密码

      $table->rememberToken();    // 记住我 令牌

      $table->timestamps();
    });
  }

  
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
