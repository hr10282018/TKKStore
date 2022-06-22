<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;



// 头像
$prefix=env('APP_URL').'/images/avatars/';
$avatars = [
  '1.jpg',
  '2.gif',
  '3.jpg',
  '4.png',
  '5.jpg',
  '6.jpg',
];


$factory->define(User::class, function (Faker $faker) use ($avatars,$prefix) {

  $updated_at = $faker->dateTimeThisYear();//返回一个前一年内的DateTime对象.指定允许的最后时间和时区
  $created_at = $faker->dateTimeThisYear($updated_at);

  return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'email_verified_at' => now(),
      'avatar' => $prefix.$faker->randomElement($avatars),
      'signature'=>Str::random(45),
      'sex'=> $faker->randomElement(['男', '女']),
      'activated' => true,
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
      'created_at' => $created_at,
      'updated_at' => $updated_at,
  ];
});
