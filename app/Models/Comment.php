<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
     'content'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);   // 一个回复属于一个作者
  }

 public function goods()    // 注意命名规范
  {
    return $this->belongsTo(Good::class);   // 一个回复属于一个商品
  }

}
