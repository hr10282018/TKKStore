<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisible extends Model
{
  protected $fillable = [
    'v_email', 'v_phone',
    'v_university',
    'v_faculty',
    'v_number',
    'v_r_name',

    'v_buy_booking_goods',
    'v_buy_sale_goods',
    'v_booking_goods',
    'v_sale_goods',
    'v_saled_goods',
    'v_comment',
  ];

  protected $casts = [
    'v_email' => 'boolean',
    'v_phone' => 'boolean',
    'v_university' => 'boolean',
    'v_faculty' => 'boolean',
    'v_number' => 'boolean',
    'v_r_name' => 'boolean',

    'v_buy_booking_goods' => 'boolean',
    'v_buy_sale_goods' => 'boolean',
    'v_booking_goods' => 'boolean',
    'v_sale_goods' => 'boolean',
    'v_saled_goods' => 'boolean',
    'v_comment' => 'boolean',
  ];


  // 一个可见属于一个用户
  

  

}
