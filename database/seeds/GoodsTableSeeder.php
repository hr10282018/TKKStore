<?php

use Illuminate\Database\Seeder;
use App\Models\Good;

class GoodsTableSeeder extends Seeder
{

  public function run()
  {
    factory(Good::class)->times(100)->create();
  }

}
