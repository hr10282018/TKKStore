<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SeedCategoriesData extends Migration
{

  public function up()
  {
    

    $categories = [
      [
        'name'        => '学习',
        'description' => '书籍、电子资料等',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name'        => '生活',
        'description' => '生活用品、衣饰装扮等',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name'        => '娱乐',
        'description' => '电子设备、运动器材等',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name'        => '其他',
        'description' => '其他神马',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
    ];
    DB::table('categories')->insert($categories);
  }

  public function down()
  {
    //2022_01_26_112659
    //2022_01_26_135425
   

    DB::table('categories')->truncate();
    //Schema::dropIfExists('categories');
  }
}
