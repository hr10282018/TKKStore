<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{

  public function up()
  {
    $categories = [
      [
        'name'        => '学习',
        'description' => '书籍、电子资料等',
      ],
      [
        'name'        => '生活',
        'description' => '生活用品、衣饰装扮等',
      ],
      [
        'name'        => '娱乐',
        'description' => '电子设备、运动器材等',
      ],
      [
        'name'        => '其他',
        'description' => '其他神马',
      ],
    ];
    DB::table('categories')->insert($categories);
  }

  public function down()
  {
    DB::table('categories')->truncate();
  }
}
