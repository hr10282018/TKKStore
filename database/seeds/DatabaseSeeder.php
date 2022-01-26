<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
      $this->call(UsersTableSeeder::class); // 用户

      $this->call(GoodsSeeder::class);   // 商品

      $this->call(CommentsTableSeeder::class);  // 商品评论

    }
}
