<?php

use Illuminate\Database\Seeder;
use App\Models\Good;

class GoodsSeeder extends Seeder
{

  public function run()
  {
    factory(Good::class)->times(200)->create();
  }

}
