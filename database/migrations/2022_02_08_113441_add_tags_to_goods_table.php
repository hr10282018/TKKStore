<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsToGoodsTable extends Migration
{

  public function up()
  {
    Schema::table('goods', function (Blueprint $table) {
      $table->string('tags')->nullable();   // 所属标签字段
    });
  }


  public function down()
  {
    Schema::table('goods', function (Blueprint $table) {
      $table->dropColumn('tags');
    });
  }
}
