<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    
    public function run()
    {
       // 生成数据集合
       $users = factory(User::class)->times(10)->create();

       // 单独处理第一个用户的数据
       $user = User::find(1);
       $user->name = 'Sakura';
       $user->email = '1902422119@qq.com';
       $user->avatar = 'http://onestore.tkk/images/avatars/1.png';
       $user->signature='Something for nothing';
       $user->save();
    }
}
