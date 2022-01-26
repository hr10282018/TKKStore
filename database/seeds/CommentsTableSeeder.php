<?php

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{

  public function run()
  {
    factory(Comment::class)->times(400)->create();
  }
}
