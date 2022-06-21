<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id');
      
      $table->string('name',8)->comment('名称');   //

      $table->string('description',32)->nullable()->comment('描述'); // comment-表注释
      
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('categories');
  }

}
