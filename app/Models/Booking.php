<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

  protected $fillable = [
    'goods_id', 'user_id', 'buyer_id', 'user_state', 'reason'
  ];

}
