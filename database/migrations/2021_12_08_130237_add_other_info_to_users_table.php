<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherInfoToUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {

      $table->string('avatar',255)->nullable();    //头像-图片路径

      $table->string('signature', 80)->nullable(); // 个签

      $table->string('sex', 2)->nullable();    //性别
      $table->string('phone', 11)->nullable();        //手机号
      $table->string('university')->default('xxx大学');   // 大学

      $table->string('faculty')->nullable();  // 院系
      $table->string('number', 8)->nullable(); // 学号

      $table->string('activation_token',32)->nullable(); // 邮箱验证令牌

      $table->boolean('activated')->default(false);   // 是否验证邮箱(tinyint)
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('avatar');
      $table->dropColumn('signature');
      $table->dropColumn('sex');
      $table->dropColumn('phone');
      $table->dropColumn('university');
      $table->dropColumn('faculty');
      $table->dropColumn('number');
      $table->dropColumn('activation_token');
      $table->dropColumn('activated');
    });
  }
}
