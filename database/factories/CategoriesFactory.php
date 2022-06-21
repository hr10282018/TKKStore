<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

  // $updated_at = $faker->dateTimeThisMonth(); // DateTime对象.指定允许的最后时间和时区
  // $created_at = $faker->dateTimeThisMonth($updated_at);

  return [
      
  ];

});
