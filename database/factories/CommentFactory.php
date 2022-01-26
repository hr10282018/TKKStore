<?php

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
  $updated_at = $faker->dateTimeThisMonth(); //返回前一个月内的DateTime对象.
  $created_at = $faker->dateTimeThisMonth($updated_at);

  return [
    "goods_id" => $faker->numberBetween(1, 100),   // 商品id
    'user_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),  // 用户id
    'content' => $faker->sentence(),    //返回句子
    'created_at' => $created_at,
    'updated_at' => $updated_at,
  ];
});
