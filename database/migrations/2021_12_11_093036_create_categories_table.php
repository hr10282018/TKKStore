<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {

      $table->increments('id');
      $table->string('name')->index()->comment('名称');   //
      $table->text('description')->nullable()->comment('描述'); // comment-表注释
      $table->integer('count')->default(0)->comment('商品数');
    });
  }


  public function down()
  {
    Schema::dropIfExists('categories');
  }
}
