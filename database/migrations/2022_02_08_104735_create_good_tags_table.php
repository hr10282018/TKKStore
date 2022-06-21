<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodTagsTable extends Migration
{

  public function up()
  {
    Schema::create('good_tags', function (Blueprint $table) {
      
      $table->increments('id');
      
      $table->string('name', 8);   // 6

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('good_tags');
  }
}
