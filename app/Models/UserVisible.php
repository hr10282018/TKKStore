<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisible extends Model
{
  protected $fillable = [
    'v_email','v_phone','v_university',
    'v_faculty','v_number','v_r_name'
  ];

  protected $casts = [
    'v_email' => 'boolean',
    'v_phone' => 'boolean',
    'v_university' => 'boolean',
    'v_faculty' => 'boolean',
    'v_number' => 'boolean',
    'v_r_name' => 'boolean',
  ];
  

}
