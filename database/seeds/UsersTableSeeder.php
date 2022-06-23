<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

  public function run()
  {
    // 生成数据集合
    $users = factory(User::class)->times(10)->create();
    // foreach ($users as $user) {
    //   // 创建10个商品，并且每个商品 的 `user_id` 字段都设为当前循环的用戶id
    //   $goods= factory(\App\Models\Good::class,10)->create(['user_id' => $user->id]);
    // }
    foreach($users as $user){
      $user_v=factory(\App\Models\UserVisible::class,1)->create(['user_id' => $user->id]);
    }

    // 单独处理第一个用户的数据
    $user = User::find(1);
    $user->name = 'Sakura';
    $user->email = '1902422119@qq.com';
    $user->avatar = env('APP_URL').'/images/avatar.png';
    $user->signature = 'Something for nothing';
    $user->save();
  }

}
