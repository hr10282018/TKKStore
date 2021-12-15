<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
  use Notifiable;

  protected $fillable = [
    'name', 'email', 'password', 'avatar',
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public static function boot() // boot-用户模型类完成初始化之后进行加载
  {
    parent::boot();

    static::creating(function ($user) {
      $user->activation_token = Str::random(10);  // 生成邮箱令牌
    });
  }

  public function goods()
  {
    return $this->hasMany(Good::class);     // 一个用户有多个商品
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);     // 一个用户有多个评论
  }


}
