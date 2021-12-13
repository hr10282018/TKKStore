<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
  $date_time = $faker->date . ' ' . $faker->time;
  return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'email_verified_at' => now(),
      'activated' => true,
      'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
      'remember_token' => Str::random(10),
      'created_at' => $date_time,
      'updated_at' => $date_time,
  ];
});
