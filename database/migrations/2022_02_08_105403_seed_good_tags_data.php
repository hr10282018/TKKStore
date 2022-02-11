<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedGoodTagsData extends Migration
{

  public function up()
  {
    $categories = [
      [
        'name' => '原装正品',
      ],
      [
        'name' => '如假包退',
      ],
      [
        'name' => '价格可谈',
      ],
      [
        'name' => '一口价',
      ],
      [
        'name' => '交个朋友',
      ],
      [
        'name' => '诚意转让',
      ],

    ];
    DB::table('good_tags')->insert($categories);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::table('good_tags')->truncate();
  }
}
