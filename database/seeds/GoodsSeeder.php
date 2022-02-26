<?php

use Illuminate\Database\Seeder;
use App\Models\Good;

class GoodsSeeder extends Seeder
{

  public function run()
  {
    $goods=factory(Good::class)->times(200)->create();

    foreach($goods as $good){
      factory(\App\Models\Comment::class,3)->create(['goods_id' => $good->id]);
    }

  }

}
