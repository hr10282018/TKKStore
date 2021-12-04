<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

  // 注册
  public function create()
  {
    return view('users.signup');
  }

}
