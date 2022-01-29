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

          $table->string('avatar')->nullable();		//头像-存储图片路径
          $table->string('signature',255)->nullable(); // 个签
          $table->string('sex',4)->nullable();    //性别
          $table->string('phone',11)->nullable();        //手机号
          $table->string('university')->default('厦大嘉庚')->nullable();   // 大学
          $table->string('faculty')->nullable();  // 院系
          $table->string('number',8)->nullable(); // 学号

          $table->string('activation_token')->nullable(); // 邮箱认证
          $table->boolean('activated')->default(false);

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
