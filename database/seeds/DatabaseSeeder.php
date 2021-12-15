<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UsersTableSeeder::class); // 用户

      $this->call(GoodsTableSeeder::class);   // 商品

      $this->call(CommentsTableSeeder::class);  // 商品评论
    }
}
