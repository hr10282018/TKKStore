<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

// 头像
$avatars = [
  'http://onestore.tkk/images/avatars/1.png',
  'http://onestore.tkk/images/avatars/2.jpg',
  'http://onestore.tkk/images/avatars/3.jpg',
  'http://onestore.tkk/images/avatars/7.jpg',
  'http://onestore.tkk/images/avatars/5.jpg',
  'http://onestore.tkk/images/avatars/6.jpg',
];

$factory->define(User::class, function (Faker $faker) use ($avatars) {

  $updated_at = $faker->dateTimeThisYear();//返回一个前一年内的DateTime对象.指定允许的最后时间和时区
  $created_at = $faker->dateTimeThisYear($updated_at);

  return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'email_verified_at' => now(),
      'avatar' => $faker->randomElement($avatars),
      'signature'=>$faker->sentence(),
      'sex'=> $faker->randomElement(['男', '女']),
      'activated' => true,
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
      'created_at' => $created_at,
      'updated_at' => $updated_at,
  ];
});
